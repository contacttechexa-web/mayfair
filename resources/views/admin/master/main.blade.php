@php
    $isFrameRequest = request()->boolean('_frame');
    $frameUrl = request()->fullUrlWithQuery(['_frame' => 1]);
@endphp
<!DOCTYPE html>
<html lang="en">
     <link rel="icon" type="image/png" href="https://img.freepik.com/premium-vector/hrm-human-resource-management-icon-label-badge-vector-stock-illustration_100456-10641.jpg">
@include('admin.partials.style')
<body class="{{ $isFrameRequest ? 'admin-frame-shell' : 'layout-boxed admin-dashboard-shell' }}">
<script>
    // Force light mode - remove dark mode
    (function() {
        // Remove dark class from body
        document.body.classList.remove('dark');
        
        // Set darkMode to false in localStorage if theme exists
        try {
            var theme = localStorage.getItem("theme");
            if (theme) {
                var themeObj = JSON.parse(theme);
                if (themeObj.settings && themeObj.settings.layout) {
                    themeObj.settings.layout.darkMode = false;
                    localStorage.setItem("theme", JSON.stringify(themeObj));
                }
            }
        } catch(e) {
            // If theme doesn't exist or parsing fails, create default light theme
            var defaultTheme = {
                settings: {
                    layout: {
                        darkMode: false
                    }
                }
            };
            localStorage.setItem("theme", JSON.stringify(defaultTheme));
        }
    })();
</script>
    <style>
        .content-load-screen {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: transparent;
            z-index: 2000;
            pointer-events: none;
        }

        .content-load-screen.is-visible {
            display: flex;
        }

        .content-load-screen .loader-content {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 108px;
            height: 108px;
            border-radius: 30px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, 0.98), rgba(239, 246, 255, 0.96));
            border: 1px solid rgba(37, 99, 235, 0.1);
            box-shadow:
                0 28px 60px rgba(15, 23, 42, 0.14),
                0 10px 24px rgba(37, 99, 235, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            overflow: hidden;
        }

        .content-load-screen .loader-content::before {
            content: '';
            position: absolute;
            inset: 10px;
            border-radius: 24px;
            border: 1px solid rgba(37, 99, 235, 0.08);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.65), rgba(219, 234, 254, 0.2));
        }

        .content-load-screen .loader-content::after {
            content: '';
            position: absolute;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 3px solid rgba(37, 99, 235, 0.12);
            border-top-color: rgba(37, 99, 235, 0.85);
            animation: contentLoaderSpin 0.9s linear infinite;
        }

        .content-load-screen .spinner-grow {
            position: relative;
            z-index: 1;
            width: 16px;
            height: 16px;
            color: #2563eb;
            box-shadow: 0 0 0 10px rgba(37, 99, 235, 0.08);
        }

        @keyframes contentLoaderSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .admin-content-frame {
            width: 100%;
            height: calc(100vh - 120px);
            min-height: calc(100vh - 120px);
            border: 0;
            border-radius: 18px;
            background: transparent;
            display: block;
        }

        .admin-frame-shell {
            background: #f8fafc;
            overflow-y: auto !important;
        }

        .admin-frame-content {
            min-height: 100vh;
            padding: 12px;
        }

        @media (max-width: 991.98px) {
            .admin-content-frame {
                height: calc(100vh - 98px);
                min-height: calc(100vh - 98px);
                border-radius: 16px;
            }

            .admin-frame-content {
                padding: 10px;
            }
        }
    </style>

    @if(!$isFrameRequest)
        <!-- BEGIN LOADER -->
        <div id="load_screen"> <div class="loader"> <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div></div></div>
        <!--  END LOADER -->
        <!--  BEGIN NAVBAR  -->
        @if(!isset($hideSidebar) || !$hideSidebar)
        @include('admin.partials.header')
        @endif
        <!--  END NAVBAR  -->

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container admin-main-container" id="container">

            <div class="overlay"></div>
            <div class="search-overlay"></div>

            <!--  BEGIN SIDEBAR  -->
            @if(!isset($hideSidebar) || !$hideSidebar)
            @include('admin.partials.siderbar')
            @endif
            <!--  END SIDEBAR  -->
            
            <!--  BEGIN CONTENT AREA  -->
            <div id="content" class="main-content admin-main-content">
                <div class="layout-px-spacing">
                    <div id="content_load_screen" class="content-load-screen">
                        <div class="loader-content">
                            <div class="spinner-grow" role="status" aria-label="Loading content"></div>
                        </div>
                    </div>
                    <iframe
                        id="adminContentFrame"
                        class="admin-content-frame"
                        name="adminContentFrame"
                        src="{{ $frameUrl }}"
                        loading="eager"></iframe>
                </div>
            </div>
            <!--  END CONTENT AREA  -->

        </div>
        <!-- END MAIN CONTAINER -->
    @else
        <div class="admin-frame-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div class="row layout-top-spacing">
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('admin.partials.footer')
        </div>
    @endif

  @include('admin.partials.script')
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script>
        // Ensure light mode is always active
        document.addEventListener('DOMContentLoaded', function() {
            // Remove dark class if present
            document.body.classList.remove('dark');
            
            // Update localStorage to ensure darkMode is false
            try {
                var theme = localStorage.getItem("theme");
                if (theme) {
                    var themeObj = JSON.parse(theme);
                    if (themeObj.settings && themeObj.settings.layout) {
                        themeObj.settings.layout.darkMode = false;
                        localStorage.setItem("theme", JSON.stringify(themeObj));
                    }
                }
            } catch(e) {
                console.log('Theme initialization completed');
            }
        });
        
        // Also check after a short delay to catch any late-loading scripts
        setTimeout(function() {
            document.body.classList.remove('dark');
        }, 100);

        (function() {
            const isFrameRequest = @json($isFrameRequest);

            function withFrameParam(urlValue) {
                const url = new URL(urlValue, window.location.origin);
                url.searchParams.set('_frame', '1');
                return url.toString();
            }

            function stripFrameParam(urlValue) {
                const url = new URL(urlValue, window.location.origin);
                url.searchParams.delete('_frame');
                return url.toString();
            }

            if (!isFrameRequest) {
                function setFrameLoadingState(isLoading) {
                    var loader = document.getElementById('content_load_screen');

                    if (!loader) {
                        return;
                    }

                    loader.classList.toggle('is-visible', isLoading);
                }

                window.addEventListener('message', function(event) {
                    if (event.origin !== window.location.origin || !event.data) {
                        return;
                    }

                    if (event.data.type === 'admin-frame:loading') {
                        setFrameLoadingState(true);
                        return;
                    }

                    if (event.data.type !== 'admin-frame:navigated') {
                        return;
                    }

                    if (event.data.title) {
                        document.title = event.data.title;
                    }

                    if (event.data.url) {
                        history.replaceState({ adminFrameUrl: event.data.url }, '', event.data.url);
                    }
                });

                window.addEventListener('popstate', function() {
                    const frame = document.getElementById('adminContentFrame');

                    if (!frame) {
                        return;
                    }

                    setFrameLoadingState(true);
                    frame.src = withFrameParam(window.location.href);
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const frame = document.getElementById('adminContentFrame');

                    if (!frame) {
                        setFrameLoadingState(false);
                        return;
                    }

                    frame.addEventListener('load', function() {
                        setFrameLoadingState(false);
                    });

                    if (frame.src) {
                        setFrameLoadingState(true);
                    } else {
                        setFrameLoadingState(false);
                    }
                });

                return;
            }

            function notifyParent() {
                if (window.parent === window) {
                    return;
                }

                window.parent.postMessage({
                    type: 'admin-frame:navigated',
                    title: document.title,
                    url: stripFrameParam(window.location.href)
                }, window.location.origin);
            }

            function notifyParentLoading() {
                if (window.parent === window) {
                    return;
                }

                window.parent.postMessage({
                    type: 'admin-frame:loading'
                }, window.location.origin);
            }

            document.addEventListener('click', function(event) {
                const link = event.target.closest('a[href]');

                if (!link) {
                    const submitButton = event.target.closest('button, input[type="submit"], input[type="button"]');

                    if (!submitButton) {
                        return;
                    }

                    const form = submitButton.form;
                    const buttonType = (submitButton.getAttribute('type') || '').toLowerCase();
                    const isButtonSubmit = submitButton.tagName === 'BUTTON' && form && buttonType !== 'button';
                    const isInputSubmit = submitButton.tagName === 'INPUT' && submitButton.getAttribute('type') === 'submit';

                    if (isButtonSubmit || isInputSubmit) {
                        notifyParentLoading();
                    }

                    return;
                }

                const href = link.getAttribute('href');

                if (!href || href === '#' || href.startsWith('javascript:') || link.hasAttribute('download')) {
                    return;
                }

                if (link.target && link.target !== '_self') {
                    return;
                }

                const url = new URL(link.href, window.location.origin);

                if (url.origin !== window.location.origin) {
                    return;
                }

                notifyParentLoading();
                event.preventDefault();
                window.location.href = withFrameParam(url.toString());
            });

            document.addEventListener('submit', function(event) {
                const form = event.target;

                if (!(form instanceof HTMLFormElement)) {
                    return;
                }

                notifyParentLoading();

                const method = (form.getAttribute('method') || 'get').toLowerCase();

                if (method !== 'get') {
                    return;
                }

                let frameInput = form.querySelector('input[name="_frame"]');

                if (!frameInput) {
                    frameInput = document.createElement('input');
                    frameInput.type = 'hidden';
                    frameInput.name = '_frame';
                    form.appendChild(frameInput);
                }

                frameInput.value = '1';
            });

            window.addEventListener('load', notifyParent);
        })();
    </script>

</body>
</html>
