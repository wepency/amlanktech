<ul class="side-menu">
    <li class="side-item side-item-category">لوحة التحكم</li>

    <!-- Homepage Link -->
    <li class="slide">
        <a class="side-menu__item" href="{{url('/')}}">

            <svg class="svg-icon side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                 width="24">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"></path>
                <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"></path>
            </svg>

            <span class="side-menu__label">موقع اتحاد الملاك</span>
        </a>
    </li>

    @if(can('view dashboard'))
        <!-- Dashboard Link -->
        <li class="slide">

            <a class="side-menu__item" href="{{route('dashboard.home')}}">

                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/>
                    <path
                        d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/>
                </svg>

                <span class="side-menu__label">لوحة التحكم</span>
            </a>
        </li>
    @endif

    <!-- Association Member -->
    @if(can('view association member requests'))
        <li class="slide">
            <a class="side-menu__item" href="{{dashboard_route('units.requests')}}">

                <i class="svg-icon side-menu__icon si si-doc"></i>

                <span class="side-menu__label">طلبات انضمام الملاك<span class="badge bg-danger" style="position:absolute;left:20px;">{{ getUserRequestCount()  }}</span></span>
            </a>
        </li>
    @endif

    <li class="side-item side-item-category">
        <span>{{is_admin() ? 'الجمعيات' : 'الجمعية'}}</span>
    </li>

    @if(canOr(['view associations', 'view units']))
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <i class="svg-icon side-menu__icon si si-organization"></i>

                <span class="side-menu__label">{{is_admin() ? 'الجمعيات' : 'الجمعية'}}</span>

                <i class="angle fe fe-chevron-down"></i>
            </a>

            <ul class="slide-menu">
                @if(is_admin())
{{--                    @if(can('view associations'))--}}
                        <li>
                            <a class="slide-item" href="{{route('dashboard.associations.index')}}"> الجمعيات</a>
                        </li>
{{--                    @endif--}}
                @endif

                @if(can('view association units'))
                    <li>
                        <a class="slide-item" href="{{route('dashboard.units.index')}}"> الوحدات</a>
                    </li>
                @endif

            </ul>

        </li>
    @endif

    @if(canOr(['view users', 'view managers', 'view employees', 'view outsource employees', 'view association members', 'view association member requests']))
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <i class="svg-icon side-menu__icon si si-people"></i>

                <span class="side-menu__label">المستخدمون</span>

                <i class="angle fe fe-chevron-down"></i>
            </a>

            <ul class="slide-menu">
{{--                @if(!is_manager())--}}
{{--                    @if(can('view managers'))--}}
                        <li>
                            <a class="slide-item" href="{{dashboard_route('admins.index')}}"> مديري التطبيق</a>
                        </li>
{{--                    @endif--}}

{{--                    @if(can('view association heads'))--}}
                        <li>
                            <a class="slide-item" href="{{dashboard_route('managers.index')}}"> اعضاء الجمعية </a>
                        </li>
{{--                    @endif--}}
{{--                @endif--}}

{{--                @if(can('view outsource employees'))--}}
                    <li>
                        <a class="slide-item" href="{{route('dashboard.outsource_employees.index')}}"> الموظفون خارج
                            النظام</a>
                    </li>
{{--                @endif--}}

                @if (can('view association members'))
                    <li>
                        <a class="slide-item" href="{{route('dashboard.members.index')}}"> الملاك </a>
                    </li>
                @endif

            </ul>

        </li>
    @endif

    @if(can('view service company contracts'))
        <li class="slide">
            <a class="side-menu__item" href="{{route('dashboard.companies.index')}}">

                <i class="side-menu__icon si si-chart"></i>

                <span class="side-menu__label">عقود الشركات الخدمية</span>
            </a>
        </li>
    @endif

    @if(can('view support tickets'))
        <!----- Tickets -->

        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                     width="24px" fill="#000000">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path
                        d="M11 18h2v-2h-2v2zm0-4h2V7h-2v7zm8-6h-6v2h6V7zm0 4h-6v2h6v-2zm0 4h-6v2h6v-2zm3-12h-2v2h2V3zm0 4h-2v2h2V7zm0 4h-2v2h2v-2zm0 4h-2v2h2v-2zm-4-10H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.11 0 2-.9 2-2V5c0-1.1-.89-2-2-2zm0 16H5V5h14v14z"/>
                </svg>

                <span class="side-menu__label">الطلبات</span>

                <i class="angle fe fe-chevron-down"></i>
            </a>

            <ul class="slide-menu">
                <li>
                    <a class="slide-item" href="{{route('dashboard.tickets.index')}}"> الطلبات </a>
                    <a class="slide-item" href="{{route('dashboard.ticket-categories.index')}}"> تصنيفات الطلبات </a>
                </li>
            </ul>
        </li>
    @endif

    @if(can('view permits'))
        <!-- Permits -->
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <i class="svg-icon side-menu__icon si si-ban"></i>

                <span class="side-menu__label">تصاريح الزيارة</span>

                <i class="angle fe fe-chevron-down"></i>
            </a>

            <ul class="slide-menu">
                <li>
                    <a class="slide-item" href="{{route('dashboard.permits.requests')}}"> طلبات التصاريح

                        <span class="badge bg-danger"
                              style="position:absolute;left:20px;">{{getPermitsRequests()}}</span>
                    </a>
                </li>

                <li>
                    <a class="slide-item" href="{{route('dashboard.permits.index')}}"> التصاريح
                    </a>
                </li>

                <li>
                    <a class="slide-item" href="{{route('dashboard.permits.index')}}">تصنيفات التصاريح</a>
                </li>

                <li>
                    <a class="slide-item" href="{{route('dashboard.permits.blocklist.index')}}">حظر رقم هوية</a>
                </li>
            </ul>

        </li>
    @endif

    @if(can('view ads'))
        <!----- Posts -->
        <li class="slide">
            <a class="side-menu__item" href="{{route('dashboard.posts.index')}}">
                <i class="side-menu__icon si si-picture"></i>

                <span class="side-menu__label">المنشورات</span>
            </a>
        </li>
    @endif

    <!----- Tasks -->
    <li class="slide">
        <a class="side-menu__item" href="{{route('dashboard.tasks.index')}}">
            <i class="side-menu__icon si si-list"></i>

            <span class="side-menu__label">المهام</span>
        </a>
    </li>

    @if(can('view meetings'))
        <!----- Meetings -->
        <li class="slide">
            <a class="side-menu__item" href="{{route('dashboard.meetings.index')}}">

                <i class="side-menu__icon si si-camrecorder"></i>

                <span class="side-menu__label">الاجتماعات</span>
            </a>
        </li>
    @endif

    <!----- Policies -->
    @if (can('view policies'))
        <li class="slide">
            <a class="side-menu__item" href="{{route('dashboard.policies.index')}}">
                <i class="side-menu__icon si si-book-open"></i>

                <span class="side-menu__label">اللوائح</span>
            </a>
        </li>
    @endif

    <li class="side-item side-item-category">الحسابات</li>

    @if(can('view subscriptions'))
        <!----- Subscriptions -->
        <li class="slide">
            <a class="side-menu__item" href="{{route('dashboard.subscriptions.index')}}">
                <i class="si si-event side-menu__icon"></i>
                <span class="side-menu__label">الاشتراكات</span>
            </a>
        </li>
    @endif

    @if(can('view association budget'))
        <!----- Budget -->
        <li class="slide">
            <a class="side-menu__item" href="{{route('dashboard.budget')}}">
                <i class="side-menu__icon si si-wallet"></i>

                <span class="side-menu__label">الميزانية</span>
            </a>
        </li>
    @endif

     @if (can('view gifts'))
    <li class="slide">
        <a class="side-menu__item " href="{{route('dashboard.gifts.index')}}">
            <i class="side-menu__icon si si-bag"></i>
            <span class="side-menu__label">الهبات</span>
        </a>
    </li>
     @endif

    @if(canOr(['view income receipts', 'view payment receipt requests', 'view payment receipts']))
        <!-- Receipts -->
        <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                <i class="side-menu__icon si si-docs"></i>

                <span class="side-menu__label">السندات</span>

                <i class="angle fe fe-chevron-down"></i>
            </a>

            <ul class="slide-menu">
                <!-- Payment Receipts -->
                @if (can('view income receipts'))
                    <li>
                        <a class="slide-item" href="{{dashboard_route('income-receipts.index')}}"> سندات القبض
                        </a>
                    </li>
                @endif

                <!-- Hold Receipts -->
                @if (can('view payment receipt requests'))
                    <li>
                        <a class="slide-item" href="{{dashboard_route('payment-receipts.index', ['type' => 'requests'])}}">
                            سندات الصرف المقيدة</a>
                    </li>
                @endif

                <!-- Receipts -->
                @if (can('view payment receipts'))
                    <li>
                        <a class="slide-item" href="{{dashboard_route('payment-receipts.index')}}"> سندات الصرف</a>
                    </li>
                @endif
            </ul>

        </li>
    @endif

    <li class="side-item side-item-category">الإعدادات</li>

    @if(can('view roles'))
        <!----- Roles -->
        <li class="slide">
            <a class="side-menu__item" href="{{route('dashboard.roles.index')}}">
                <i class="side-menu__icon si si-briefcase"></i>

                <span class="side-menu__label">الصلاحيات</span>
            </a>
        </li>
    @endif

    @if(can('view receipt categories'))
        <!----- Payment Receipts Categories -->
        <li class="slide">
            <a class="side-menu__item" href="{{dashboard_route('receipt-categories.index')}}">
                <i class="side-menu__icon si si-grid"></i>

                <span class="side-menu__label">تصنيفات السندات</span>
            </a>
        </li>
    @endif

</ul>
