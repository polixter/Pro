<?php
include $_SERVER['DOCUMENT_ROOT'].'/utils/db.php';
?>

<nav class="bg-gray-200 border-gray-500 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-800">
    <div class="container mx-auto flex flex-wrap items-center justify-between">
        <a href="/" class="flex">
            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="50" height="50">
                <style>
                .s0 {
                    fill: #96af0b
                }

                .s1 {
                    fill: #79692b
                }
                </style>
                <path id="Layer" class="s0"
                    d="m14.6 2c-2 0.2-3.5 0.3-4.7 0.5-1.2 0.2-1.6 0.3-1.8 0.5-0.2 0.1-0.3 0.2-0.2 0.6 0 0.6 0.2 0.7 1.9 1.1 0.8 0.1 1.9 0.4 2.5 0.5 1 0.2 1.2 0.2 1.9 0.2 0.5-0.1 2.2-0.1 3.8-0.2 4.4 0 6 0.1 7.5 0.9 1.3 0.6 1.9 1.4 2.4 3 0.3 1.3 0.4 2.2 0.4 7.7-0.1 4.8-0.1 5.1-0.3 5.7-0.5 1.8-1.3 2.7-3.2 3.3-1.4 0.5-3.2 0.6-7.7 0.7-4.6 0-5.6-0.1-7.1-0.9-0.8-0.4-1.7-1.2-2-1.9-0.3-0.6-0.7-1.7-0.8-2.2-0.1-0.3-0.2-0.5-0.9-1.2-0.5-0.5-1-1-1.2-1.1q-0.6-0.4-1.1 0.1c-0.2 0.3-0.2 0.4-0.2 1.1 0 1.4 0.6 3.6 1.3 4.8 1.4 2.5 3.7 4 6.9 4.5 1.7 0.2 8.2 0.1 10.7-0.2 5.4-0.6 7.9-2.7 8.7-7.2 0.1-0.8 0.2-1.5 0.2-6.2 0-4.7-0.1-5.3-0.2-6.2-0.4-2.2-1-3.8-2.1-5-1.2-1.5-2.8-2.2-5.3-2.7-0.6-0.2-1.4-0.2-4.4-0.2-1.9 0-4.2 0-5 0z" />
                <path id="Layer" class="s0"
                    d="m0.9 3.8c-0.4 0.1-0.5 0.2-0.5 2.6 0.1 2.1 0.1 2.4 0.3 3.6 0.7 3.5 1.8 5.9 3.8 7.8q2.2 2.2 5.7 2.7c2 0.3 4.1 0 5-0.6l0.2-0.2-0.2-0.2c-0.1-0.2-5-5.5-9.7-10.4q-2.9-3.1-1.4-1.7c0.4 0.3 1.3 1.2 2.1 1.9 0.8 0.7 1.9 1.8 2.6 2.3 0.6 0.6 2.2 2 3.4 3.2 1.3 1.2 2.7 2.5 3.2 2.9 0.5 0.5 0.9 0.8 0.9 0.8 0.1 0 0.1-0.3 0.3-0.7 0.1-0.5 0.1-0.9 0.1-2 0-2.1-0.3-3.7-1.2-5.5-0.7-1.4-1.9-2.8-3.2-3.7-2.2-1.5-6.4-2.6-10.4-2.8-0.5-0.1-0.9-0.1-1 0z" />
                <path id="Layer" class="s1"
                    d="m21.5 11.3c0 0.1-0.3 0.5-0.7 1-1.1 1.6-2.2 3.3-2.9 4.6-1.4 2.8-2.2 5.9-2.1 8.4v0.7l1.1 0.1c1.6 0 1.5 0.1 1.5-1.2 0-2.7 0.5-5.3 2.4-10.9 0.5-1.5 0.9-2.7 0.9-2.7q0 0-0.1 0-0.1 0-0.1 0z" />
            </svg>
        </a>
        <div class="flex md:order-2">
            <!-- Dark mode switcher -->
            <button id="theme-toggle" type="button"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>
            <!-- Dark mode switcher end -->

            <button data-collapse-toggle="mobile-menu-4" type="button"
                class="md:hidden text-gray-500 hover:bg-gray-100focus:outline-none focus:ring-2 focus:ring-gray-200 rounded-lg text-sm p-2 inline-flex items-center dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="mobile-menu-4" aria-expanded="false">
                <span class="sr-only">Abir menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="hidden md:flex justify-between items-center w-full md:w-auto md:order-1" id="mobile-menu-4">
            <ul class="flex-col md:flex-row flex md:space-x-8 mt-4 md:mt-0 md:text-sm md:font-medium">
                <li>
                    <a href="/"
                        class="text-gray-700 hover:bg-gray-50 border-b border-gray-100 md:hover:bg-transparent md:border-0 block pl-3 pr-4 py-2 md:hover:text-green-500 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Inicio</a>
                </li>
                <li>
                    <a target="_blank" href="https://www.projardimfloricultura.com.br/#contato-section"
                        class="text-gray-700 hover:bg-gray-50 border-b border-gray-100 md:hover:bg-transparent md:border-0 block pl-3 pr-4 py-2 md:hover:text-green-500 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contato</a>
                </li>
                <?php
                if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?>
                <li>
                    <a href="/manage"
                        class="text-gray-700 hover:bg-gray-50 border-b border-gray-100 md:hover:bg-transparent md:border-0 block pl-3 pr-4 py-2 md:hover:text-green-500 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Gerenciar
                        Plantas</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>