<header id="global" class="header__main">
  <div class="container max-w-[1920px] xl:px-[50px] flex justify-between items-center h-[100px]">
    <a class="brand" href="{{ home_url('/') }}">
      <svg class="fill-[#0086ce]" width="148.659" height="26.512" viewBox="0 0 148.659 26.512">
        <g transform="translate(-1177.387 -368.41)">
            <path d="M1256.61 381.314c-3.149-.866-4.188-1.334-4.188-2.741 0-1.3 1.072-2.236 2.857-2.236 2.889 0 3.636 1.407 3.8 2.633h6.688c-.162-3.787-2.792-7.755-10.453-7.755-6.363 0-10.355 3.354-10.355 8.477 0 3.535 2.045 5.555 8.148 7.286 3.473 1.01 4.188 1.767 4.188 3.138 0 1.8-1.526 2.417-3.572 2.417-2.759 0-4.09-1.3-4.383-3.21h-6.817c.422 5.447 4.123 8.4 10.875 8.4 7.4 0 11.427-3.535 11.427-8.585-.002-3.568-1.725-6.021-8.215-7.824z" transform="translate(-65.134 -2.804)"/>
            <path d="m1286.01 372.064-13.05 25.358h7.337l2.532-4.869h8.6l.65 4.869h7.109l-3.96-25.358zm-.616 14.825c1.85-4 3.408-7.467 4.22-9.631h.1c.13 2.128.52 5.627 1.039 9.631z" transform="translate(-74.913 -3.077)"/>
            <path d="M1338.177 372.064h-3.7c-2.532 5.7-5.454 12.445-6.785 16.051h-.033c.1-3.318-.195-10.533-.422-16.051h-9.761l-4.837 25.358h6.331l1.623-8.26c.656-3.5 1.227-7.921 1.644-11.053.111 6 .27 13.8.36 19.312h5.843c3.485-8.236 6.134-14.578 8-19.377-.891 3.965-1.878 8.487-2.33 10.829l-1.623 8.549h6.914l4.837-25.358z" transform="translate(-87.662 -3.077)"/>
            <path d="M1373 372.064h-11.265l-4.837 25.358h6.947l1.4-7.88h5.453c6.2 0 10.778-3.3 10.778-9.578-.002-4.906-3.314-7.9-8.476-7.9zm-2.792 12.1h-3.928l1.331-6.765h3.6c2.37 0 3.246 1.119 3.246 2.778.005 2.348-1.618 3.99-4.248 3.99z" transform="translate(-101.88 -3.077)"/>
            <path d="M1410.973 372.064c-1.467 2.16-5.27 7.448-8.163 11.451a325.407 325.407 0 0 0-3.159-11.451h-7.531l6.189 17.082a4.024 4.024 0 0 1 .126.44l-5.5 7.836h7.077l6.45-9.09 11.979-16.268z" transform="translate(-113.195 -3.077)"/>
            <path d="M1437.946 371.214c-9.966 0-14.186 8.044-14.186 15.33 0 6.24 3.571 11.182 11.265 11.182 9.609 0 14.381-7.034 14.381-15.258 0-6.312-3.863-11.254-11.46-11.254zm-2.337 21.029c-2.987 0-4.318-2.2-4.318-5.771 0-4.04 1.915-9.884 6.3-9.884 3.279 0 4.35 2.453 4.35 5.3-.002 4.475-1.755 10.355-6.332 10.355z" transform="translate(-123.36 -2.804)"/>
        </g>
      </svg>
    </a>
  
    <nav class="nav-primary flex gap-x-[54px]">
      @if (is_user_logged_in())
      <div>
        <a href="{!! wp_logout_url() !!}">로그아웃</a>
      </div>
      @endif
      {!! wp_nav_menu(['menu' => 0, 'menu_class' => 'flex gap-x-[54px]', 'echo' => false]) !!}
    </nav>
  </div>
</header>
