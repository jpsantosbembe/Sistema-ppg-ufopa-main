export interface menu {
    header?: string;
    title?: string;
    icon?: any;
    to?: string;
    chip?: string;
    BgColor?: string;
    chipBgColor?: string;
    chipColor?: string;
    chipVariant?: string;
    chipIcon?: string;
    children?: menu[];
    disabled?: boolean;
    type?: string;
    subCaption?: string;
    route?: string
}

//https://icon-sets.iconify.design/solar/
const sidebarItem: menu[] = [
    {header: 'Menu principal'},
    {
        title:'Dashboard',
        icon: 'screencast-2-line-duotone',
        BgColor: 'primary',
        to: "/dashboard",
        route:'dashboard.*'
    },
    {
        title:'Programas',
        icon: 'inbox-archive-outline',
        BgColor: 'success',
        to: "/programa",
        route:'programa.*'
    },
    {
        title:'Pessoas',
        icon: 'people-nearby-broken',
        BgColor: 'secondary',
        to: "/pessoas",
        route:'pessoas.*'
    },
    {
        title:'Projetos',
        icon: 'box-minimalistic-broken',
        BgColor: 'success',
        to: "/projeto",
        route:'projeto.*'
    },
    {
        title:'Disciplinas',
        icon: 'clipboard-broken',
        BgColor: 'success',
        to: "/disciplinas",
        route:'disciplinas.*'
    },
    {
        title:'Produções',
        icon: 'documents-outline',
        BgColor: 'success',
        to: "/producao",
        route:'producao.*'
    },
    {
        title:'Relatórios',
        icon: 'chart-2-outline',
        BgColor: 'success',
        route:'report.*',
        children:[
            {
                title:'Qualis',
                icon: 'chart-2-outline',
                BgColor: 'success',
                to: "/report/qualis",
                route:'report.qualis',
            },
            {
                title:'Orientações',
                icon: 'chart-2-outline',
                BgColor: 'success',
                to: "/report/orientations",
                route:'report.orientarion',
            }
        ]
    },
    {
        title:'Usuários',
        icon: 'users-group-rounded-broken',
        BgColor: 'primary',
        to: "/user",
        route:'user.*'
    },
    {
        title:'Uploads',
        icon: 'folder-cloud-outline',
        BgColor: 'success',
        to: "/coleta",
        route:'coleta.*'
    },


    // {header: 'Apps'},
    // {
    //     title: 'Contact',
    //     icon: 'phone-line-duotone',
    //     BgColor: 'secondary',
    //     to: '/apps/contacts',
    //     route: 'apps.contact'
    // },
    //
    // {
    //     title: 'Blog',
    //     icon: 'align-vertical-spacing-line-duotone',
    //     BgColor: 'warning',
    //     route: 'apps.blog.*',
    //     to: '/',
    //     children: [
    //         {
    //             title: 'Posts',
    //             to: '/apps/blog/posts',
    //             route: 'apps.blog.post'
    //         },
    //         {
    //             title: 'Detail',
    //             to: '/apps/blog/1',
    //             route: 'apps.blog.detail'
    //         }
    //     ]
    // },
    // {
    //     title: 'E-Commerce',
    //     icon: 'smart-speaker-minimalistic-line-duotone',
    //     to: '/ecommerce/',
    //     BgColor: 'indigo',
    //     route:'e-commerce.*',
    //     children: [
    //         {
    //             title: 'Shop One',
    //             to: '/ecommerce/products-one',
    //             route: 'e-commerce.shop.one'
    //         },
    //         {
    //             title: 'Shop Two',
    //             to: '/ecommerce/products-two',
    //             route: 'e-commerce.shop.two'
    //         },
    //         {
    //             title: 'Details One',
    //             to: '/ecommerce/product/detail/one/1',
    //             route: 'e-commerce.shop.detail.one'
    //         },
    //         {
    //             title: 'Details Two',
    //             to: '/ecommerce/product/detail/two/1',
    //             route: 'e-commerce.shop.detail.two'
    //         },
    //         {
    //             title: 'List',
    //             to: '/ecommerce/productlist',
    //             route: 'e-commerce.list'
    //         },
    //         {
    //             title: 'Checkout',
    //             to: '/ecommerce/checkout',
    //             route: 'e-commerce.checkout'
    //         }
    //     ]
    // },
    // {
    //     title: 'Chats',
    //     icon: 'chat-round-unread-line-duotone',
    //     BgColor: 'primary',
    //     to: '/apps/chats',
    //     route:'apps.chat'
    // },
    // {
    //     title: 'User Profile',
    //     icon: 'user-rounded-line-duotone',
    //     BgColor: 'error',
    //     to: '/',
    //     route:'apps.user',
    //     children: [
    //         {
    //             title: 'Profile One',
    //             to: '/apps/user/profileone',
    //             route:'apps.user.profile.one'
    //         },
    //         {
    //             title: 'Profile Two',
    //             to: '/apps/user/profiletwo',
    //             route:'apps.user.profile.two'
    //         },
    //     ]
    // },
    // {
    //     title: 'Notes',
    //     icon: 'notification-unread-line-duotone',
    //     BgColor: 'secondary',
    //     to: '/apps/notes',
    //     route:'apps.notes',
    // },
    // {
    //     title: 'Calendar',
    //     icon: 'calendar-line-duotone',
    //     BgColor: 'info',
    //     to: '/apps/calendar',
    //     route:'apps.calendar',
    // },
    // {
    //     title: 'Kanban',
    //     icon: 'widget-4-linear',
    //     BgColor: 'warning',
    //     to: '/apps/kanban',
    //     route:'apps.kanban',
    // },
    // {header: 'Pages'},
    // {
    //     title: 'Pricing',
    //     icon: 'tag-price-line-duotone',
    //     BgColor: 'warning',
    //     to: '/pages/pricing',
    //     route:'pages.pricing',
    // },
    // {
    //     title: 'FAQ',
    //     icon: 'question-circle-line-duotone',
    //     BgColor: 'error',
    //     to: '/pages/faq',
    //     route:'pages.faq',
    // },
    // {
    //     title: 'Account Setting',
    //     icon: 'settings-minimalistic-line-duotone',
    //     BgColor: 'success',
    //     to: '/pages/account-settings',
    //     route:'apps.kanban',
    // },
    // {
    //     title: 'Landing Page',
    //     icon: 'layers-minimalistic-line-duotone',
    //     BgColor: 'info',
    //     to: '/',
    //     route:'pages.account-settings',
    // },
    //
    // {
    //     title: 'Widget',
    //     icon: 'widget-add-line-duotone',
    //     to: '/widget-card',
    //     BgColor: 'primary',
    //     route:'widgets.*',
    //     children: [
    //         {
    //             title: 'Cards',
    //             to: '/widgets/cards',
    //             route:'widgets.cards',
    //         },
    //         {
    //             title: 'Banners',
    //             to: '/widgets/banners',
    //             route:'widgets.banners',
    //         },
    //         {
    //             title: 'Charts',
    //             to: '/widgets/charts',
    //             route:'widgets.charts',
    //         }
    //     ]
    // },
    //
    // {header: 'School Pages'},
    // {
    //     title: 'Teachers',
    //     icon: 'square-academic-cap-linear',
    //     to: '',
    //     BgColor: 'success',
    //     route:'teachers.*',
    //     children: [
    //         {
    //             title: 'All Teachers',
    //             to: '/teachers/all-teachers',
    //             route:'teachers.all-teachers',
    //         },
    //         {
    //             title: 'Teachers Details',
    //             to: '/teachers/teachers-details',
    //             route:'teachers.teachers-details',
    //         }
    //     ]
    // },
    // {
    //     title: 'Exam',
    //     icon: 'notebook-minimalistic-outline',
    //     to: '',
    //     BgColor: 'warning',
    //     route:'exam.*',
    //     children: [
    //         {
    //             title: 'Exam Schedule',
    //             to: '/exam/exam-schedule',
    //             route:'exam.exam-schedule',
    //         },
    //         {
    //             title: 'Exam Result',
    //             to: '/exam/exam-result',
    //             route:'exam.exam-result',
    //         },
    //         {
    //             title: 'Exam Result Details',
    //             to: '/exam/exam-result-details',
    //             route:'exam.exam-result.details',
    //         }
    //     ]
    // },
    // {
    //     title: 'Students',
    //     icon: 'case-broken',
    //     to: '',
    //     BgColor: 'error',
    //     route:'students.*',
    //     children: [
    //         {
    //             title: 'All Students',
    //             to: '/students/all-students',
    //             route:'students.all-students',
    //         },
    //         {
    //             title: 'Students Details',
    //             to: '/students/students-details',
    //             route:'students.students-details',
    //         }
    //     ]
    // },
    // {
    //     title: 'Classes',
    //     icon: 'smart-home-broken',
    //     BgColor: 'indigo',
    //     to: '/school-pages/classes',
    //     route:'classes',
    // },
    // {
    //     title: 'Attendance',
    //     icon: 'diploma-linear',
    //     BgColor: 'info',
    //     to: '/school-pages/attendance',
    //     route:'classes.details',
    // },
    // {header: 'UI'},
    // {
    //     title: 'Ui Elements',
    //     icon: 'code-scan-line-duotone',
    //     BgColor: 'primary',
    //     to: '/components/',
    //     route:'ui.*',
    //     children: [
    //         {
    //             title: 'Alert',
    //             to: '/ui-components/alert',
    //             route:'ui.alert',
    //         },
    //         {
    //             title: 'Accordion',
    //             to: '/ui-components/accordion',
    //             route:'ui.accordion',
    //         },
    //         {
    //             title: 'Avatar',
    //             to: '/ui-components/avatar',
    //             route:'ui.avatar',
    //         },
    //         {
    //             title: 'Chip',
    //             to: '/ui-components/chip',
    //             route:'ui.chip',
    //         },
    //         {
    //             title: 'Dialog',
    //             to: '/ui-components/dialogs',
    //             route:'ui.dialogs',
    //         },
    //         {
    //             title: 'List',
    //             to: '/ui-components/list',
    //             route:'ui.list',
    //
    //         },
    //         {
    //             title: 'Menus',
    //             to: '/ui-components/menus',
    //             route:'ui.menus',
    //
    //         },
    //         {
    //             title: 'Rating',
    //             to: '/ui-components/rating',
    //             route:'ui.rating',
    //
    //         },
    //         {
    //             title: 'Tabs',
    //             to: '/ui-components/tabs',
    //             route:'ui.tabs',
    //         },
    //         {
    //             title: 'Tooltip',
    //             to: '/ui-components/tooltip',
    //             route:'ui.tooltip',
    //
    //         },
    //         {
    //             title: 'Typography',
    //             to: '/ui-components/typography',
    //             route:'ui.typography',
    //         }
    //     ]
    // },
    //
    // {header: 'Forms'},
    // {
    //     title: 'Form Elements',
    //     icon: 'widget-3-line-duotone',
    //     BgColor: 'secondary',
    //     to: '/components/',
    //     route:'form.elements.*',
    //     children: [
    //         {
    //             title: 'Autocomplete',
    //             route:'form.elements.autocomplete',
    //             to: '/forms/form-elements/autocomplete'
    //         },
    //         {
    //             title: 'Combobox',
    //             route:'form.elements.combobox',
    //             to: '/forms/form-elements/combobox'
    //         },
    //         {
    //             title: 'Button',
    //             route:'form.elements.button',
    //             to: '/forms/form-elements/button'
    //         },
    //         {
    //             //Todo::create checkbox
    //             title: 'Checkbox',
    //             route:'form.elements.button',
    //             to: '/forms/form-elements/checkbox'
    //         },
    //         {
    //             title: 'Custom Inputs',
    //             route:'form.elements.custominputs',
    //             to: '/forms/form-elements/custominputs'
    //         },
    //         {
    //             title: 'File Inputs',
    //             route:'form.elements.fileinputs',
    //             to: '/forms/form-elements/fileinputs'
    //         },
    //         {
    //             title: 'Radio',
    //             route:'form.elements.radio',
    //             to: '/forms/form-elements/radio'
    //         },
    //         {
    //             title: 'Date Time',
    //             route:'form.elements.date-time',
    //             to: '/forms/form-elements/date-time'
    //         },
    //         {
    //             title: 'Select',
    //             route:'form.elements.select',
    //             to: '/forms/form-elements/select'
    //         },
    //         {
    //             title: 'Slider',
    //             route:'form.elements.slider',
    //             to: '/forms/form-elements/slider'
    //         },
    //         {
    //             title: 'Switch',
    //             route:'form.elements.switch',
    //             to: '/forms/form-elements/switch'
    //         }
    //     ]
    // },
    //
    // {
    //     title: 'Form Input',
    //     icon: 'book-minimalistic-outline',
    //     BgColor: 'success',
    //     to: '/forms/',
    //     route:'form.input.*',
    //     children: [
    //         {
    //             title: 'Form Layout',
    //             route:'form.input.*',
    //             to: '/forms/input/form-layouts'
    //         },
    //         {
    //             title: 'Form Horizontal',
    //             route:'form.input.*',
    //             to: '/forms/input/form-horizontal'
    //         },
    //         {
    //             title: 'Form Vertical',
    //             route:'form.input.*',
    //             to: '/forms//input/form-vertical'
    //         },
    //         {
    //             title: 'Form Custom',
    //             route:'form.input.*',
    //             to: '/forms/input/form-custom'
    //         },
    //         {
    //             title: 'Form Validation',
    //             route:'form.input.*',
    //             to: '/forms/input/form-validation'
    //         },
    //     ]
    // },
    // {
    //     title: 'Editor',
    //     icon: 'gallery-edit-line-duotone',
    //     BgColor: 'warning',
    //     route:'form.input.editor',
    //     to: '/forms/input/editor'
    // },
    //
    // {header: 'Tables'},
    // {
    //     title: 'Basic Table',
    //     icon: 'tablet-line-duotone',
    //     BgColor: 'info',
    //     route:'tables.basic',
    //     to: '/tables/basic'
    // },
    // {
    //     title: 'Dark Table',
    //     icon: 'bedside-table-2-linear',
    //     BgColor: 'success',
    //     route:'tables.dark',
    //     to: '/tables/dark'
    // },
    // {
    //     title: 'Density Table',
    //     icon: 'password-minimalistic-input-linear',
    //     BgColor: 'error',
    //     route:'tables.density',
    //     to: '/tables/density'
    // },
    // {
    //     title: 'Fixed Header Table',
    //     icon: 'align-left-line-duotone',
    //     BgColor: 'indigo',
    //     route:'tables.fixed-header',
    //     to: '/tables/fixed-header'
    // },
    // {
    //     title: 'Height Table',
    //     icon: 'bookmark-square-minimalistic-outline',
    //     BgColor: 'warning',
    //     route:'tables.height',
    //     to: '/tables/height'
    // },
    // {
    //     title: 'Editable Table',
    //     icon: 'pen-new-square-broken',
    //     BgColor: 'success',
    //     route:'tables.editable',
    //     to: '/tables/editable'
    // },
    //
    // {header: 'Data Tables'},
    // {
    //     title: 'Basic Table',
    //     icon: 'database-outline',
    //     route:'tables.datatables.basic',
    //     BgColor: 'primary',
    //     to: '/tables/datatables/basic'
    // },
    // {
    //     title: 'Header Table',
    //     icon: 'clapperboard-text-broken',
    //     route:'tables.datatables.header',
    //     BgColor: 'secondary',
    //     to: '/tables/datatables/header'
    // },
    // {
    //     title: 'Selection Table',
    //     icon: 'documents-minimalistic-linear',
    //     route:'tables.datatables.selection',
    //     BgColor: 'success',
    //     to: '/tables/datatables/selection'
    // },
    // {
    //     title: 'Sorting Table',
    //     route:'tables.datatables.sorting',
    //     icon: 'sort-from-bottom-to-top-linear',
    //     BgColor: 'error',
    //     to: '/tables/datatables/sorting'
    // },
    // {
    //     title: 'Pagination Table',
    //     icon: 'programming-linear',
    //     route:'tables.datatables.pagination',
    //     BgColor: 'warning',
    //     to: '/tables/datatables/pagination'
    // },
    // {
    //     title: 'Filtering Table',
    //     icon: 'filter-outline',
    //     route:'tables.datatables.filtering',
    //     BgColor: 'indigo',
    //     to: '/tables/datatables/filtering'
    // },
    // {
    //     title: 'Grouping Table',
    //     route:'tables.datatables.grouping',
    //     icon: 'users-group-rounded-line-duotone',
    //     BgColor: 'info',
    //     to: '/tables/datatables/grouping'
    // },
    // {
    //     title: 'Table Slots',
    //     icon: 'server-line-duotone',
    //     route:'tables.datatables.slots',
    //     BgColor: 'error',
    //     to: '/tables/datatables/slots'
    // },
    //
    // {header: 'Charts'},
    // {
    //     title: 'Apex Charts',
    //     icon: 'pie-chart-2-linear',
    //     BgColor: 'primary',
    //     to: '/charts/',
    //     route:'charts.*',
    //     children: [
    //         {
    //             title: 'Line',
    //             route:'charts.line',
    //             to: '/charts/line-chart'
    //         },
    //         {
    //             title: 'Gredient',
    //             route:'charts.gredient',
    //             to: '/charts/gredient-chart'
    //         },
    //         {
    //             title: 'Area',
    //             route:'charts.area',
    //             to: '/charts/area-chart'
    //         },
    //         {
    //             title: 'Candlestick',
    //             route:'charts.candlestick-chart',
    //             to: '/charts/candlestick-chart'
    //         },
    //         {
    //             title: 'Column',
    //             route:'charts.column',
    //             to: '/charts/column-chart'
    //         },
    //         {
    //             title: 'Doughnut & Pie',
    //             route:'charts.doughnut-pie',
    //             to: '/charts/doughnut-pie-chart'
    //         },
    //         {
    //             title: 'Radialbar & Radar',
    //             route:'charts.radialbar',
    //             to: '/charts/radialbar-chart'
    //         },
    //     ]
    // },
    //
    //
    // {header: 'Authentication'},
    //
    // {
    //     title: 'Login',
    //     icon: 'login-2-line-duotone',
    //     BgColor: 'warning',
    //     to: '#',
    //     children: [
    //         {
    //             title: 'Side Login',
    //             to: '/auth/login'
    //         },
    //         {
    //             title: 'Boxed Login',
    //             to: '/auth/login2'
    //         }
    //     ]
    // },
    // {
    //     title: 'Register',
    //     icon: 'user-plus-line-duotone',
    //     BgColor: 'error',
    //     to: '#',
    //     children: [
    //         {
    //             title: 'Side Register',
    //             to: '/auth/register'
    //         },
    //         {
    //             title: 'Boxed Register',
    //             to: '/auth/register2'
    //         }
    //     ]
    // },
    // {
    //     title: 'Forgot Password',
    //     icon: 'forbidden-line-duotone',
    //     BgColor: 'indigo',
    //     to: '#',
    //     children: [
    //         {
    //             title: 'Side Forgot Password',
    //             to: '/auth/forgot-password'
    //         },
    //         {
    //             title: 'Boxed Forgot Password',
    //             to: '/auth/forgot-password2'
    //         }
    //     ]
    // },
    // {
    //     title: 'Two Steps',
    //     icon: 'users-group-two-rounded-line-duotone',
    //     BgColor: 'info',
    //     to: '#',
    //     children: [
    //         {
    //             title: 'Side Two Steps',
    //             to: '/auth/two-step'
    //         },
    //         {
    //             title: 'Boxed Two Steps',
    //             to: '/auth/two-step2'
    //         }
    //     ]
    // },
    //
    // {
    //     title: 'Error',
    //     icon: 'bug-line-duotone',
    //     BgColor: 'error',
    //     to: '/auth/404'
    // },
    // {
    //     title: 'Maintenance',
    //     icon: 'settings-line-duotone',
    //     BgColor: 'primary',
    //     to: '/auth/maintenance'
    // },
    // {header: "Icons"},
    // {
    //     title: "Tabler",
    //     BgColor: 'success',
    //     icon: 'airbuds-case-linear',
    //     to: "/icons/tabler",
    // },
    //
    // {header: 'Others'},
    // {
    //     title: 'Menu Level',
    //     icon: 'double-alt-arrow-down-bold-duotone',
    //     BgColor: 'secondary',
    //     to: '#',
    //     children: [
    //         {
    //             title: 'Level 1',
    //             to: '/auth/404'
    //         },
    //         {
    //             title: 'Level 1',
    //             to: '/auth/404',
    //             children: [
    //                 {
    //                     title: 'Level 2',
    //
    //                     to: '/auth/404'
    //                 },
    //                 {
    //                     title: 'Level 2',
    //
    //                     to: '/auth/404',
    //                     children: [
    //                         {
    //                             title: 'Level 3',
    //
    //                             to: '/auth/404'
    //                         },
    //                         {
    //                             title: 'Level 3',
    //
    //                             to: '/auth/404'
    //                         }
    //                     ]
    //                 }
    //             ]
    //         }
    //     ]
    // },
    // {
    //     title: 'Disabled',
    //     icon: 'forbidden-circle-line-duotone',
    //     BgColor: 'success',
    //     disabled: true,
    //     to: '/auth/404'
    // },
    // {
    //     title: 'Sub Caption',
    //     BgColor: 'warning',
    //     icon: 'square-academic-cap-line-duotone',
    //     subCaption: 'This is the subtitle',
    //     to: '/auth/404'
    // },
    // {
    //     title: 'Chip',
    //     icon: 'archive-check-line-duotone',
    //     chip: '9',
    //     BgColor: 'error',
    //     chipColor: 'error',
    //     chipBgColor: 'error',
    //     chipVariant: 'flat',
    //     to: '/auth/404'
    // },
    // {
    //     title: 'Outlined',
    //     icon: 'smile-circle-line-duotone',
    //     chip: 'outline',
    //     chipColor: 'indigo',
    //     chipVariant: 'outlined',
    //     BgColor: 'indigo',
    //     to: '/auth/404'
    // },
    // {
    //     title: 'External Link',
    //     icon: 'link-bold-duotone',
    //     BgColor: 'info',
    //     to: '/auth/404',
    //     type: 'external'
    // }

];

export default sidebarItem;
