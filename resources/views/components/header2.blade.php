<div class="flex flex-col w-full">
  <div id="mainHeader" class="h-12 md:h-14 lg:h-16 flex items-center px-2 md:px-4 bg-gray-50">
    <div class="flex items-center">
      <a href="/landing-page"><img src="{{ asset('img/logo_paf.png') }}" alt="Logo" class="h-8 md:h-10"></a>
    </div>

    <div class="flex-1"></div>

    <div class="flex gap-1 md:gap-2 lg:gap-3 text-nowrap">
<div class="font-semibold cursor-pointer rounded-full transition-all duration-300 ease-in-out text-center border border-gray-200 hover:border-gray-600 hover:bg-gray-100 text-gray-900 bg-white 
  text-xs md:text-sm py-1.5 md:py-2 px-4 md:px-5 lg:px-6">
  Comprar produto
</div>
<a href="{{ Route::is('showRegister') || Route::is('landing') ? route('showLogin') : route('showRegister') }}">
  <div class="font-semibold cursor-pointer rounded-full transition-all duration-300 ease-in-out text-center
      bg-gray-900 text-white hover:bg-gray-800 text-xs md:text-sm py-1.5 md:py-2 px-4 md:px-5 lg:px-6">
    {{ Route::is('showRegister') || Route::is('landing') ? 'Entrar' : 'Registo' }}
  </div>
</a>
    </div>
  </div>
</div>
