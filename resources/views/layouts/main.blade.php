<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
<title>MovieHub - Đặt vé xem phim trực tuyến</title>


    <link rel="stylesheet" href="/css/main.css">
    <livewire:styles>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
<link rel="stylesheet"
      href="{{ asset('css/moviehub-custom.css') }}">

</head>
<body class="font-sans bg-gray-900 text-white">
    <nav class="moviehub-navbar border-b border-gray-800">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between px-4 py-6">
            <ul class="flex flex-col md:flex-row items-center">
                <li>
                    
<a href="{{ route('movies.index') }}"
   style="display:inline-flex;
          align-items:center;
          gap:10px;
          text-decoration:none;
          white-space:nowrap;">

    <svg width="32" height="32"
         viewBox="0 0 24 24"
         fill="none"
         stroke="white"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">

        <path d="M4 11h16v10H4z"/>
        <path d="m4 11-1-5 18-4 1 5-18 4Z"/>
        <path d="m8 10-1-5"/>
        <path d="m13 9-1-5"/>

    </svg>

    <span style="color:white;
                 font-size:22px;
                 font-weight:bold;">
        MovieHub
    </span>

</a>

                </li>
                <li class="md:ml-16 mt-3 md:mt-0">
                    
                <a href="{{ route('cinema.movies.index') }}" class="hover:text-gray-300">Movies</a>

                </li>
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{ route('tv.index') }}" class="hover:text-gray-300">TV Shows</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{ route('actors.index') }}" class="hover:text-gray-300">Actors</a>
                </li>
                
                @auth
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{ url('/my-bookings') }}"
                    class="hover:text-gray-300"
                    style="color:#ff914d;">
                        Vé của tôi
                    </a>
                </li>
@endauth


@auth
@if(auth()->user()->role === 'admin')
    <li style="position:relative; margin-left:24px; list-style:none;">

        <details style="position:relative; display:inline-block;">

            <summary style="
                color:#ff914d;
                cursor:pointer;
                font-weight:600;
                white-space:nowrap;
                list-style:none;">
                Quản trị ▼
            </summary>

            <div style="
                position:absolute;
                top:calc(100% + 12px);
                left:0;
                width:240px;
                background:#2d3748;
                border:1px solid #475569;
                border-radius:10px;
                box-shadow:0 10px 20px rgba(0,0,0,0.3);
                z-index:9999;
                padding:8px 0;">

                @if(Route::has('admin.dashboard'))
                    <a href="{{ route('admin.dashboard') }}"
                       style="display:block; padding:12px 16px;
                       color:white; text-decoration:none;
                       white-space:nowrap;">
                        Tổng quan quản trị
                    </a>
                @endif

                @if(Route::has('admin.movies.index'))
                    <a href="{{ route('admin.movies.index') }}"
                       style="display:block; padding:12px 16px;
                       color:white; text-decoration:none;
                       white-space:nowrap;">
                        Quản lý phim
                    </a>
                @endif

                @if(Route::has('admin.showtimes.index'))
                    <a href="{{ route('admin.showtimes.index') }}"
                       style="display:block; padding:12px 16px;
                       color:white; text-decoration:none;
                       white-space:nowrap;">
                        Quản lý suất chiếu
                    </a>
                @endif

                <a href="{{ url('/admin/bookings') }}"
                   style="display:block; padding:12px 16px;
                   color:white; text-decoration:none;
                   white-space:nowrap;">
                    Quản lý đặt vé
                    
@if(Route::has('admin.tickets.lookup'))

    <a href="{{ route('admin.tickets.lookup') }}"
       style="
           display:block;
           padding:12px 16px;
           color:#ff914d;
           text-decoration:none;
           white-space:nowrap;
           font-weight:600;
       ">
        Tra cứu & Kiểm vé
    </a>

@endif

                </a>

            </div>
        </details>
    </li>
@endif
@endauth

            </ul>
            
<button
    type="button"
    class="mh-mobile-menu-toggle"
    aria-label="Mở menu"
    aria-expanded="false"
    onclick="
        const nav = this.closest('nav');
        const opened = nav.classList.toggle('mh-mobile-open');
        this.setAttribute('aria-expanded', opened);
        this.textContent = opened ? '✕' : '☰';
    ">
    ☰
</button>

            <div class="flex flex-col md:flex-row items-center">
                <livewire:search-dropdown>
                
<div class="md:ml-4 mt-3 md:mt-0"
     style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">

    @auth
        
<a href="{{ route('profile.avatar.edit') }}"
   title="Thay đổi ảnh đại diện"
   style="display:inline-flex; align-items:center; flex-shrink:0;">

    <img src="{{ auth()->user()->avatar
        ? asset(auth()->user()->avatar)
        : asset('img/avatar.jpg') }}"
         alt="Ảnh đại diện"
         style="width:32px;
                height:32px;
                border-radius:50%;
                object-fit:cover;
                border:2px solid #ff914d;">

</a>

        <span style="color:white;">
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}"
              style="margin:0;">
            @csrf

            <button type="submit"
                    style="background:#ff914d; color:#111;
                           padding:8px 12px; border-radius:6px;
                           cursor:pointer;">
                Đăng xuất
            </button>
        </form>
    @endauth

    @guest
        <a href="{{ route('login') }}"
           style="color:white; text-decoration:none;">
            Đăng nhập
        </a>

        <a href="{{ route('register') }}"
           style="background:#ff914d; color:#111;
                  padding:8px 12px; border-radius:6px;
                  text-decoration:none;">
            Đăng ký
        </a>
    @endguest

</div>

            </div>
        </div>
    </nav>
    @yield('content')
    

<!-- MOVIEHUB FOOTER - DESKTOP & MOBILE -->

<style>
.mhf-footer,
.mhf-footer * {
    box-sizing: border-box;
}

.mhf-footer {
    width: 100%;
    background: #303030;
    color: #e5e7eb;
    padding: 52px 20px 20px;
    margin-top: 40px;
    font-family: Arial, sans-serif;
}

.mhf-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

/* FOUR COLUMNS */

.mhf-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 32px;
    margin-bottom: 38px;
}

.mhf-column {
    min-width: 0;
}

.mhf-column h3 {
    margin: 0 0 24px;
    color: #ff914d;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.mhf-column > a {
    display: block;
    margin-bottom: 17px;
    color: #d1d5db;
    font-size: 15px;
    line-height: 1.6;
    text-decoration: none;
    transition: color 0.2s ease;
}

.mhf-column > a:hover {
    color: #ff914d;
}

/* MOVIEHUB LOGO */

.mhf-brand-lockup {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.mhf-brand-symbol {
    color: #ff914d;
    width: 42px;
    height: 42px;
    flex-shrink: 0;
}

.mhf-brand-name {
    color: white;
    font-size: 25px;
    line-height: 1.2;
    font-weight: 800;
}

.mhf-brand-subtitle {
    margin: 4px 0 15px;
    color: #cbd5e1;
    font-size: 12px;
    letter-spacing: 1px;
}

.mhf-brand-description {
    color: #cbd5e1;
    font-size: 13px;
    line-height: 1.7;
    margin: 0 0 16px;
}

/* SOCIAL MEDIA */

.mhf-socials {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.mhf-social {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 9px;
    color: #ffffff;
    text-decoration: none;
    transition: transform 0.2s ease;
}

.mhf-social:hover {
    transform: translateY(-3px);
}

.mhf-facebook {
    background: #1877f2;
    font-family: Arial, sans-serif;
    font-size: 29px;
    font-weight: bold;
}

.mhf-youtube {
    background: #ff0033;
}

.mhf-instagram {
    background: linear-gradient(
        135deg,
        #f9ce34,
        #ee2a7b 50%,
        #6228d7
    );
}

.mhf-social svg {
    width: 23px;
    height: 23px;
}

/* COMPANY DETAILS */

.mhf-divider {
    height: 1px;
    background: #676767;
    margin-bottom: 28px;
}

.mhf-contact {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding-bottom: 25px;
}

.mhf-contact-logo {
    width: 60px;
    height: 60px;
    color: #ff914d;
    flex-shrink: 0;
}

.mhf-contact-info {
    min-width: 0;
}

.mhf-contact-info h3 {
    color: #ffffff;
    font-size: 21px;
    font-weight: 700;
    margin: 0 0 12px;
}

.mhf-contact-info p {
    margin: 8px 0;
    color: #cbd5e1;
    font-size: 14px;
    line-height: 1.7;
}

.mhf-contact-info a {
    color: #e5e7eb;
    text-decoration: none;
}

.mhf-contact-info a:hover {
    color: #ff914d;
}

.mhf-copyright {
    border-top: 1px solid #575757;
    padding-top: 18px;
    text-align: center;
    color: #aeb9c8;
    font-size: 13px;
}

/* TABLET */

@media screen and (max-width: 900px) {
    .mhf-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 30px 22px;
    }
}

/* MOBILE */

@media screen and (max-width: 600px) {
    .mhf-footer {
        padding: 34px 16px 20px;
        margin-top: 28px;
    }

    .mhf-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 28px 16px;
        margin-bottom: 28px;
    }

    .mhf-column h3 {
        font-size: 13px;
        line-height: 1.4;
        margin-bottom: 15px;
    }

    .mhf-column > a {
        font-size: 13px;
        margin-bottom: 12px;
        overflow-wrap: anywhere;
    }

    .mhf-brand-symbol {
        width: 35px;
        height: 35px;
    }

    .mhf-brand-name {
        font-size: 19px;
    }

    .mhf-brand-lockup {
        gap: 6px;
    }

    .mhf-brand-subtitle {
        font-size: 10px;
        line-height: 1.5;
    }

    .mhf-brand-description {
        font-size: 12px;
    }

    .mhf-social {
        width: 38px;
        height: 38px;
    }

    .mhf-socials {
        gap: 8px;
    }

    .mhf-contact {
        gap: 12px;
    }

    .mhf-contact-logo {
        width: 43px;
        height: 43px;
    }

    .mhf-contact-info h3 {
        font-size: 17px;
    }

    .mhf-contact-info p {
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .mhf-copyright {
        font-size: 11px;
        line-height: 1.7;
    }
}
</style>

<footer class="mhf-footer">
    <div class="mhf-container">

        <!-- TOP SECTION -->
        <div class="mhf-grid">

            <!-- INTRODUCTION -->
            <nav class="mhf-column" aria-label="Giới thiệu">
                <h3>GIỚI THIỆU</h3>

                <a href="{{ url('/') }}">
                    Về MovieHub
                </a>

                <a href="{{ url('/cinema/movies') }}">
                    Danh sách phim
                </a>

                <a href="{{ url('/bookings/create') }}">
                    Đặt vé trực tuyến
                </a>
            </nav>

            <!-- CINEMA -->
            <nav class="mhf-column" aria-label="Góc điện ảnh">
                <h3>GÓC ĐIỆN ẢNH</h3>

                <a href="{{ url('/') }}">
                    Phim nổi bật
                </a>

                <a href="{{ url('/cinema/movies') }}">
                    Phim đang chiếu
                </a>

                <a href="{{ url('/my-bookings') }}">
                    Vé của tôi
                </a>
            </nav>

            <!-- SUPPORT -->
            <nav class="mhf-column" aria-label="Hỗ trợ">
                <h3>HỖ TRỢ</h3>

                <a href="tel:0961426537">
                    Liên hệ MovieHub
                </a>

                <a href="tel:0961426537">
                    Hỗ trợ đặt vé
                </a>

                <a href="https://www.google.com/maps/search/?api=1&amp;query=140%20Le%20Trong%20Tan%20Phuong%20Tay%20Thanh%20TP%20HCM"
                   target="_blank"
                   rel="noopener noreferrer">
                    Hướng dẫn đường đi
                </a>
            </nav>

            <!-- BRAND + SOCIALS -->
            <div class="mhf-column mhf-brand">

                <div class="mhf-brand-lockup">
                    <svg class="mhf-brand-symbol"
                         viewBox="0 0 48 48"
                         fill="none"
                         aria-hidden="true">
                        <path d="M9 19L38 11L41 20L12 28Z"
                              stroke="currentColor"
                              stroke-width="3"
                              stroke-linejoin="round"/>
                        <path d="M11 28H41V41H11Z"
                              stroke="currentColor"
                              stroke-width="3"
                              stroke-linejoin="round"/>
                        <path d="M17 17L24 25M28 14L35 22"
                              stroke="currentColor"
                              stroke-width="3"/>
                    </svg>

                    <strong class="mhf-brand-name">
                        MovieHub
                    </strong>
                </div>

                <p class="mhf-brand-subtitle">
                    CINEMA & ONLINE TICKETS
                </p>

                <p class="mhf-brand-description">
                    Khám phá điện ảnh, đặt vé trực tuyến
                    và trải nghiệm những bộ phim hấp dẫn.
                </p>

                <!-- SOCIAL MEDIA LINKS -->
                <div class="mhf-socials">

                    <!-- FACEBOOK -->
                    <a href="https://www.facebook.com/"
                       class="mhf-social mhf-facebook"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="Facebook">
                        f
                    </a>

                    <!-- YOUTUBE -->
                    <a href="https://www.youtube.com/"
                       class="mhf-social mhf-youtube"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="YouTube">
                        <svg viewBox="0 0 24 24"
                             aria-hidden="true">
                            <path d="M9 6.5L18 12L9 17.5Z"
                                  fill="white"/>
                        </svg>
                    </a>

                    <!-- INSTAGRAM -->
                    <a href="https://www.instagram.com/"
                       class="mhf-social mhf-instagram"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="Instagram">
                        <svg viewBox="0 0 24 24"
                             fill="none"
                             stroke="white"
                             stroke-width="2"
                             aria-hidden="true">
                            <rect x="3" y="3"
                                  width="18" height="18"
                                  rx="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5"
                                    r="1" fill="white"
                                    stroke="none"/>
                        </svg>
                    </a>

                </div>
            </div>
        </div>

        <div class="mhf-divider"></div>

        <!-- CONTACT INFORMATION -->
        <div class="mhf-contact">

            <svg class="mhf-contact-logo"
                 viewBox="0 0 48 48"
                 fill="none"
                 aria-hidden="true">
                <path d="M9 19L38 11L41 20L12 28Z"
                      stroke="currentColor"
                      stroke-width="3"
                      stroke-linejoin="round"/>
                <path d="M11 28H41V41H11Z"
                      stroke="currentColor"
                      stroke-width="3"
                      stroke-linejoin="round"/>
                <path d="M17 17L24 25M28 14L35 22"
                      stroke="currentColor"
                      stroke-width="3"/>
            </svg>

            <div class="mhf-contact-info">

                <h3>MOVIEHUB CINEMA</h3>

                <p>
                    📍 140 Lê Trọng Tấn,
                    Phường Tây Thạnh, TP.HCM
                </p>

                <p>
                    📞 Hotline:
                    <a href="tel:0961426537">
                        0961426537
                    </a>
                </p>

                <p>
                    🎟️ Đặt vé xem phim trực tuyến
                </p>

            </div>
        </div>

        <!-- COPYRIGHT -->
        <div class="mhf-copyright">
            © {{ date('Y') }} MovieHub Cinema.
            All rights reserved.
        </div>

    </div>
</footer>



    <livewire:scripts>
    @yield('scripts')
</body>
</html>
