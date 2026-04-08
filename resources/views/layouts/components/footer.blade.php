<style>
    .fw-extrabold {
        font-weight: 900 !important;
    }

    .typed-cursor {
        display: inline-block;
        width: 2px;
        height: 1.1em;
        background-color: white;
        margin-left: 4px;
        animation: blink 0.9s infinite;
        vertical-align: text-bottom;
    }

    @keyframes blink {

        0%,
        50% {
            opacity: 1;
        }

        51%,
        100% {
            opacity: 0;
        }
    }
</style>

<footer
    class="text-white"
    style="background: rgb(13, 18, 107)"
>
    <!-- Top Section -->
    <div class="container mx-auto px-4 py-8 sm:px-6">
        <div class="flex flex-col items-center justify-between gap-8 md:flex-row md:items-start">

            <!-- Logo -->
            <div class="flex-shrink-0 text-center">
                <img
                    src="{{ asset('assets/client/images/logo.png') }}"
                    alt="Expose FC"
                    class="mx-auto h-32 w-auto brightness-0 invert sm:h-36 md:h-36"
                >
            </div>

            <!-- Divider (desktop only) -->
            <div class="hidden h-24 w-px bg-gray-400 md:block"></div>

            <!-- Email -->
            <div class="text-center md:text-left">
                <p class="text-sm uppercase tracking-wider text-gray-300">Email</p>
                <p class="mt-1 text-lg font-bold sm:text-xl">info@exposefc.co.id</p>
            </div>

            <!-- Divider (desktop only) -->
            <div class="hidden h-24 w-px bg-gray-400 md:block"></div>

            <!-- Social Media -->
            <div class="text-center md:text-left">
                <p class="text-sm uppercase tracking-wider text-gray-300">Media Sosial</p>
                <div class="mt-2 flex justify-center space-x-5 md:justify-start">
                    <a
                        href="https://www.facebook.com/exposefc"
                        target="_blank"
                        class="transition-transform hover:scale-110"
                        aria-label="Facebook"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="white"
                            class="h-5 w-5 sm:h-6 sm:w-6"
                        >
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                            />
                        </svg>
                    </a>
                    <a
                        href="https://www.instagram.com/exposefc/"
                        target="_blank"
                        class="transition-transform hover:scale-110"
                        aria-label="Instagram"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="white"
                            class="h-5 w-5 sm:h-6 sm:w-6"
                        >
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                            />
                        </svg>
                    </a>
                    <a
                        href="https://twitter.com/exposefc"
                        target="_blank"
                        class="transition-transform hover:scale-110"
                        aria-label="Twitter"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="white"
                            class="h-5 w-5 sm:h-6 sm:w-6"
                        >
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
                            />
                        </svg>
                    </a>
                    <a
                        href="https://www.linkedin.com/company/exposefc/"
                        target="_blank"
                        class="transition-transform hover:scale-110"
                        aria-label="LinkedIn"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="white"
                            class="h-5 w-5 sm:h-6 sm:w-6"
                        >
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Animated Title -->
    <h1
        id="typed"
        class="fw-extrabold text-uppercase my-6 text-center text-white"
        style="font-size: clamp(2.5rem, 8vw, 7.5rem); line-height: 1;"
    ></h1>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-700 py-4">
        <div class="container mx-auto px-4 text-center">
            <p class="text-xs text-gray-400 sm:text-sm">
                &copy; 2025 Expose FC. All rights reserved. | Powered by Aurel Fristian Ramdhani Hatorangan Simanjuntak
            </p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('typed');
        const texts = ['PT AKSII', 'Expose FC'];
        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let currentText = '';
        let lastTime = performance.now();
        let animationId = null;

        el.innerHTML = '<span class="typed-cursor"></span>';

        const typoChance = 0.06;
        const typoChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%';

        function getRandom(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function getRandomTypoChar() {
            return typoChars.charAt(getRandom(0, typoChars.length - 1));
        }

        function updateDisplay(text) {
            el.innerHTML = text + '<span class="typed-cursor"></span>';
        }

        function handleTypo(fullText) {
            return new Promise((resolve) => {
                const typoChar = getRandomTypoChar();
                const typoText = fullText.substring(0, charIndex) + typoChar;
                updateDisplay(typoText);

                setTimeout(() => {
                    currentText = fullText.substring(0, charIndex);
                    updateDisplay(currentText);
                    charIndex++;
                    resolve();
                }, getRandom(250, 450));
            });
        }

        async function type(now) {
            const dt = now - lastTime;
            const minDelay = isDeleting ? 30 : 60;
            const maxDelay = isDeleting ? 90 : 160;
            const shouldAct = dt > getRandom(minDelay, maxDelay);

            if (!shouldAct) {
                animationId = requestAnimationFrame(type);
                return;
            }

            lastTime = now;
            const currentString = texts[textIndex];

            if (!isDeleting) {
                if (charIndex < currentString.length) {
                    if (Math.random() < typoChance) {
                        await handleTypo(currentString);
                    } else {
                        charIndex++;
                        currentText = currentString.substring(0, charIndex);
                        updateDisplay(currentText);
                    }
                } else {
                    await new Promise((resolve) => {
                        setTimeout(() => {
                            isDeleting = true;
                            resolve();
                        }, getRandom(1500, 2300));
                    });
                }
            } else {
                if (charIndex > 0) {
                    charIndex--;
                    currentText = currentString.substring(0, charIndex);
                    updateDisplay(currentText);
                } else {
                    isDeleting = false;
                    textIndex = (textIndex + 1) % texts.length;
                    await new Promise((resolve) => {
                        setTimeout(resolve, getRandom(500, 900));
                    });
                }
            }

            animationId = requestAnimationFrame(type);
        }

        const initialDelay = setTimeout(() => {
            animationId = requestAnimationFrame(type);
        }, 600);

        // Cleanup function
        window.addEventListener('beforeunload', () => {
            if (animationId) cancelAnimationFrame(animationId);
            clearTimeout(initialDelay);
        });
    });
</script>
