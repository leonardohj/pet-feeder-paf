<div
    x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
    x-cloak
>
    <div
        class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6"
        @click.away="close()"
    >

        {{-- Title --}}
        <h2 class="text-xl font-semibold mb-4" x-text="title"></h2>

        {{-- Content --}}
        <div>
            {{ $slot }}
        </div>

    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            open: false,
            title: '',
    
            payload: {},
    
            openModal({ title = '', payload = {} } = {}) {
                this.title = title;
                this.payload = payload;
                this.open = true;
            },
    
            close() {
                this.open = false;
                this.payload = {};
            }
        });
    });
    </script>