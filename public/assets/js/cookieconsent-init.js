var LOREM_IPSUM = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

// obtain cookieconsent plugin
var cc = initCookieConsent();

// run plugin with config object
cc.run({
    current_lang: 'en',
    autoclear_cookies: true,                    // default: false
    cookie_name: 'cc_cookie_demo2',             // default: 'cc_cookie'
    cookie_expiration: 365,                     // default: 182
    page_scripts: true,                         // default: false
    force_consent: true,                        // default: false

    // auto_language: null,                     // default: null; could also be 'browser' or 'document'
    // autorun: true,                           // default: true
    // delay: 0,                                // default: 0
    // hide_from_bots: false,                   // default: false
    // remove_cookie_tables: false              // default: false
    // cookie_domain: location.hostname,        // default: current domain
    // cookie_path: '/',                        // default: root
    // cookie_same_site: 'Lax',
    // use_rfc_cookie: false,                   // default: false
    // revision: 0,                             // default: 0

    gui_options: {
        consent_modal: {
            layout: 'cloud',                    // box,cloud,bar
            position: 'bottom center',          // bottom,middle,top + left,right,center
            transition: 'slide'                 // zoom,slide
        },
        settings_modal: {
            layout: 'bar',                      // box,bar
            position: 'left',                   // right,left (available only if bar layout selected)
            transition: 'slide'                 // zoom,slide
        }
    },

    onFirstAction: function(){
        console.log('onFirstAction fired');
    },

    onAccept: function (cookie) {
        console.log('onAccept fired!')
    },

    onChange: function (cookie, changed_preferences) {
        console.log('onChange fired!');

        // If analytics category is disabled => disable google analytics
        if (!cc.allowedCategory('analytics')) {
            typeof gtag === 'function' && gtag('consent', 'update', {
                'analytics_storage': 'denied'
            });
        }
    },

    languages: {
        'en': {
            consent_modal: {
                title: 'Witaj, czas na ciasteczka!',
                description: 'Nasza strona internetowa wykorzystuje niezbędne pliki cookie, aby zapewnić jej prawidłowe działanie oraz śledzące pliki cookie, aby zrozumieć, w jaki sposób z niej korzystasz. Te ostatnie zostaną ustawione dopiero po wyrażeniu zgody. <a href="/regulamin/" class="cc-link">Regulamin</a>',
                primary_btn: {
                    text: 'Akceptuj',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Ustawienia',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Drogi użytkowniku, regulamin zmienił się od Twojej ostatniej wizyty!'
            },
            settings_modal: {
                title: 'Ustawienia plików cookie',
                save_settings_btn: 'Zapisz aktualne ustawienia',
                accept_all_btn: 'Akceptuj',
                reject_all_btn: 'Odrzuć',
                close_btn_label: 'Zamknij',
                cookie_table_headers: [
                    {col1: 'Name'},
                    {col2: 'Domain'},
                    {col3: 'Expiration'}
                ],
                blocks: [
                    {
                        title: 'Wykorzystanie plików cookie',
                        description: LOREM_IPSUM + ' <a href="/regulamin/" class="cc-link">Regulamin</a>.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: LOREM_IPSUM + LOREM_IPSUM + "<br><br>" + LOREM_IPSUM + LOREM_IPSUM,
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Analityczne i wydajnościowe pliki cookie',
                        description: LOREM_IPSUM,
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                        cookie_table: [
                            {
                                col1: '^_ga',
                                col2: 'yourdomain.com',
                                col3: 'description ...',
                                is_regex: true
                            },
                            {
                                col1: '_gid',
                                col2: 'yourdomain.com',
                                col3: 'description ...',
                            },
                            {
                                col1: '_my_cookie',
                                col2: 'yourdomain.com',
                                col3: 'test cookie with custom path ...',
                                path: '/demo'       // needed for autoclear cookies
                            }
                        ]
                    }, {
                        title: 'Targetujące i reklamowe pliki cookie',
                        description: 'Jeśli ta kategoria jest odznaczona, <b>strona zostanie ponownie załadowana po zapisaniu preferencji</b>... <br><br>(przykład demonstracyjny z włączoną opcją ponownego ładowania, dla skryptów takich jak Microsoft Clarity, które ponownie ustawią pliki cookie i wysyłaj sygnały nawigacyjne nawet po wyczyszczeniu plików cookie przez funkcję autoclear cookieconsent)',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                        cookie_table: [
                            {
                                col1: '^_cl',               // New option in v2.4: regex (microsoft clarity cookies)
                                col2: 'yourdomain.com',
                                col3: 'These cookies are set by microsoft clarity',
                                // path: '/',               // New option in v2.4
                                is_regex: true              // New option in v2.4
                            }
                        ]
                    }, {
                        title: 'Więcej informacji',
                        description: LOREM_IPSUM + ' <a class="cc-link" href="/kontakt/">Kontakt</a>.',
                    }
                ]
            }
        }
    }
});