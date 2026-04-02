<div 
    x-data="{ open:false }"
    x-on:open-modal-associate-feeder.window="open = true"
>

    <!-- Background -->
    <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="bg-[rgba(0,0,0,0.6)] fixed inset-0 flex justify-center items-center z-50"
    ></div>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition
        class="m-2 fixed inset-0 flex justify-center items-center z-50"
    >
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl p-8 relative">

            <!-- Close -->
            <button
                @click="open = false"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition text-2xl font-bold"
            >
                &times;
            </button>

            <h2 class="text-3xl font-bold text-gray-900 mb-4 text-center md:text-left">
                Associar Alimentador
            </h2>

            <p class="text-gray-600 mb-6 text-center md:text-left">
                Insere o ID do alimentador que queres associar à tua conta.
            </p>

            <form action="{{ route('feeder.linkUser') }}" method="POST">
                @csrf

                <div class="relative mb-6">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">🔗</span>

                    <input
                        name="code"
                        type="text"
                        placeholder="ID do alimentador"
                        class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black transition text-gray-900 placeholder-gray-400"
                    />
                </div>

                <button
                    class="bg-black hover:bg-gray-900 transition-all duration-300 text-white font-semibold px-6 py-4 rounded-lg w-full"
                >
                    Associar
                </button>
            </form>

        </div>
    </div>

</div>