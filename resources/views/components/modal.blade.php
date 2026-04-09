<div x-data="qrScannerModal()" x-on:open-modal-associate-feeder.window="open = true" x-cloak>

    <!-- BACKDROP -->
    <div x-show="open" x-transition.opacity @click="closeMain()" class="fixed inset-0 bg-black/60 z-40"></div>


    <!-- MAIN MODAL -->
    <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-lg md:max-w-2xl rounded-xl shadow-xl p-6 relative">

            <button @click="closeMain()" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 text-2xl">
                &times;
            </button>

            <h2 class="text-xl md:text-2xl font-bold mb-4 text-center md:text-left">
                Associar Alimentador
            </h2>

            <p class="text-gray-600 mb-6 text-sm md:text-base">
                Insere o ID do alimentador ou usa a câmara para ler o QR code.
            </p>

            <form action="{{ route('feeder.linkUser') }}" method="POST" class="space-y-4">
                @csrf

                <div class="relative">

                    <input id="feederCodeInput" name="code" type="text" placeholder="ID do alimentador"
                        class="w-full py-3 pl-4 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black outline-none" />

                    <button type="button" @click="openScanner()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-black">
                        <x-mdi-qrcode-scan class="h-5 w-5" />
                    </button>

                </div>

                <button type="submit" class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-900 transition">
                    Associar
                </button>

            </form>

        </div>
    </div>


    <!-- SCANNER MODAL -->
    <div x-show="scannerModal" x-transition.opacity
        class="fixed inset-0 bg-black/80 z-[60] flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-4 relative">

            <button @click="closeScanner()" class="absolute right-3 top-3 text-gray-500 text-xl">
                &times;
            </button>

            <h3 class="text-center font-semibold mb-3">
                Scan QR Code
            </h3>

            <!-- SCANNER CONTAINER -->
            <div class="scanner-wrapper">

                <div id="qrScanner"></div>

            </div>

        </div>

    </div>

</div>



<style>
    .scanner-wrapper {
        width: 100%;
        height: 300px;
        max-height: 60vh;
        overflow: hidden;
        border-radius: 10px;
        background: black;
    }

    #qrScanner video {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }

    #qrScanner {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
</style>


<script src="https://unpkg.com/html5-qrcode"></script>

<script>
function qrScannerModal(){

return{

open:false,
scannerModal:false,
qrScanner:null,

openScanner(){

this.scannerModal=true

setTimeout(()=>{

if(!this.qrScanner){
this.qrScanner=new Html5Qrcode("qrScanner")
}

this.qrScanner.start(
{ facingMode:"environment" },
{
fps:10,
qrbox:{ width:220, height:220 }
},

(decodedText)=>{

document.getElementById("feederCodeInput").value=decodedText

// stop scanner but DON'T close main modal
this.closeScanner()

}

).catch(err=>console.log(err))

},150)

},

async closeScanner(){

if(this.qrScanner){

try{
await this.qrScanner.stop()
await this.qrScanner.clear()
}catch(e){}

this.qrScanner=null

}

this.scannerModal=false

},

async closeMain(){

await this.closeScanner()

this.open=false

}

}
}
</script>