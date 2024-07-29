@extends('Frontend.Layouts.Page')

@section('page_title', 'اتحاد الملاك')

@section('content')

    <div class="about">

        <div class="text-about">
            <h1 class="">من نحن </h1>

            <p class="text">
                شركة اتحاد الكلام هي شركة استشارات هندسية متخصصة
                في تقديم الخدمات الاستشارية لإدارة وتشغيل وتوظيف التقنيات
                الناشئة لخدمة المنشآت وإيجاد الحلول المناسبة للاستفادة من
                الطاقة المتجددة والبديلة لتوفير بيئات عمل آمنة والامتثال الى
                التنظيمات الدولية والإقليمية والمحلية لحوكمة بيئية واجتماعية
                أفضل, ويتم تقديم خدمات الشركة من خلال خبراء استراتيجيين
                وتقنيين متمرسين في المجال بهدف إحداث تأثير نوعي وكمي إيجابي في
                الأسواق الناشئة والعمل على تطوير التقنيات الحديثة لحلول مستدامة
                وصديقة للبيئة ورسم قصص نجاح مع عملائنا لإحداث التغيير المطلوب
                ومواكبة التحول السريع في السوق السعودي بأحدث الحلول الذكية
            </p>

            <div>
                <a href="{{url('contact-us')}}" class="read-more"> تواصل معنا </a>
            </div>

        </div>

        <div class='img'>
            <img src="{{asset('assets/front/about.jpg')}}" height="500px" width="500px">
        </div>
    </div>

    <section class="cards" id="services">
        <h2 class="title">خدماتنا</h2>

        <div class="content-service">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <a href="{{url('pages/digital-analysis')}}" class="card image-full">
                        <div class="card-container">

                            <div class="image-box">
                                <img src="{{asset('assets/front/1.jpg')}}" alt=""/>
                            </div>

                            <div class="content-box">
                                <h4>التحول الرقمي</h4>
                            </div>

                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-12">
                    <a href="{{url('pages/smart-cities')}}" class="card image-full">
                        <div class="card-container">

                            <div class="image-box">
                                <img src="{{asset('assets/front/2.png')}}" alt=""/>
                            </div>

                            <div class="content-box">
                                <h4>المدن الذكية</h4>
                            </div>

                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-12">
                    <a href="{{url('pages/smart-manufacture')}}" class="card image-full">
                        <div class="card-container">

                            <div class="image-box">
                                <img src="{{asset('assets/front/3.jpg')}}" alt=""/>
                            </div>

                            <div class="content-box">
                                <h4>التصنيع الذكي</h4>
                            </div>

                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-12">
                    <a href="{{url('pages/medical-care')}}" class="card image-full">
                        <div class="card-container">

                            <div class="image-box">
                                <img src="{{asset('assets/front/4.jpg')}}" alt=""/>
                            </div>

                            <div class="content-box">
                                <h4>الرعاية الصحية الذكية</h4>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

        </div>
    </section>


    <section class="card-icons" id="services">
        <h2 class="title">منهجيتنا في إدارة الاستشارات </h2>
        <p> نعمل من خلال الخطوات التالية في النطاقات الصغيرة </p>
        <div class="content-icon">
            <div class="card-icon">
                <div class="icon-circle">
                    <img src="{{asset('assets/front/icon1.png')}}" height="60px" width="60px">
                </div>
                <h4>01</h4>

                <div class="info-icon">
                    <h3> الدراسة والتحليل</h3>
                    <p>
                        تقديم دراسات استشارية متخصصة في مجموعة من الأنظمة التقنية وابراز التفاصيل المهمة لصنع القرار
                    </p>
                </div>

            </div>


            <div class="card-icon-m">
                <div class="icon-circle">
                    <img src="{{asset('assets/front/icon2.png')}}" height="60px" width="60px">

                </div>
                <h4>02</h4>

                <div class="info-icon">
                    <h3> الدراسة والتحليل</h3>
                    <p>
                        تقديم دراسات استشارية متخصصة في مجموعة من الأنظمة التقنية وابراز التفاصيل المهمة لصنع القرار
                    </p>
                </div>

            </div>


            <div class="card-icon">
                <div class="icon-circle">
                    <img src="{{asset('assets/front/icon3.png')}}" height="60px" width="60px">

                </div>
                <h4>03</h4>

                <div class="info-icon">
                    <h3> الدراسة والتحليل</h3>
                    <p>
                        تقديم دراسات استشارية متخصصة في مجموعة من الأنظمة التقنية وابراز التفاصيل المهمة لصنع القرار
                    </p>
                </div>

            </div>


        </div>
    </section>

    <section class="card-icons" id="services">
        <h2 class="title">القيمة المضافة </h2>

        <div class="content-icon">
            <div class="card-icon2">
                <div class="icon2-circle">
                    <img src="{{asset('assets/front/icon4.png')}}" height="60px" width="60px">
                </div>

                <div class="info-icon">
                    <h3> الدراسة والتحليل</h3>
                    <p>
                        تقديم دراسات استشارية متخصصة في مجموعة من الأنظمة التقنية وابراز التفاصيل المهمة لصنع القرار
                    </p>
                </div>

            </div>

            <div class="card-icon2">

                <div class="icon2-circle">
                    <img src="{{asset('assets/front/icon5.png')}}" height="60px" width="60px" alt=""/>
                </div>

                <div class="info-icon">
                    <h3> الدراسة والتحليل</h3>

                    <p>
                        تقديم دراسات استشارية متخصصة في مجموعة من الأنظمة التقنية وابراز التفاصيل المهمة لصنع القرار
                    </p>
                </div>

            </div>


            <div class="card-icon2">
                <div class="icon2-circle">
                    <img src="{{asset('assets/front/icon6.png')}}" height="60px" width="60px">

                </div>
                <div class="info-icon">
                    <h3> الدراسة والتحليل</h3>

                    <p>
                        تقديم دراسات استشارية متخصصة في مجموعة من الأنظمة التقنية وابراز التفاصيل المهمة لصنع القرار
                    </p>
                </div>

            </div>


        </div>
    </section>

    <section class="cards subscriptions" id="subscriptions">

        <div class="section-container">
            <div class="text-center">
                <h4 class="title m-0 mb-2">الباقات</h4>
                <h6>قيمة مضافة لأعمالك … وضمان ذهبي مدته 21 يومًا</h6>
            </div>

            <div class="content-service mt-5">
                <div class="row">
                    <div class="col-md-3 col-sm-12">

                        <div class="card text-center p-3">

                            <h6><strong>اشتراك فردي</strong></h6>

                            <p>
                                تم تصميم هذه الحزمة لتلبية احتياجات العقاريين، الملاك الأفراد، وأصحاب المكاتب الناشئة. حيث
                                تمكنهم من إدارة تحصيلات ومستحقات العقود، ومتابعة مصروفات العقار مع تنبيهات للدفعات، وإنشاء
                                سندات القبض تلقائيًا، وإصدار الفواتير الإلكترونية المتوافقة مع معايير الهيئة. كما تزوّدهم
                                بخاصيتي إخلاء الوحدات وتجديد العقود، وذلك بإمكانهم إضافة عدد غير محدود من العقارات والوحدات،
                                وعدد لا نهائي من العقود والمستأجرين.
                            </p>

                            <h4><strong>199 ر.س. شهريا</strong></h4>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-12">

                        <div class="card text-center p-3">

                            <h6><strong>باقة المجموعات</strong></h6>

                            <p>
                                تم تخصيص هذه الحزمة خصيصًا للوسطاء العقاريين المحترفين ومكاتب العقارات. توفر الحزمة متابعة
                                للعمليات اليومية بواسطة أتمتة كاملة لعمليات التأجير والتشغيل والصيانة، ويمكن تتبعها باستخدام
                                تقارير تفصيلية قابلة للتخصيص. بالإضافة إلى ذلك، تقدم الحزمة شاشة مؤشرات ذكية، وتحتوي على
                                نظام محاسبة متكامل، وفاتورة آلية، وإمكانية إصدار الفواتير وتقديم الضرائب نيابةً عن طرف ثالث.
                                كما توفر شاشة لعقود المؤرشفة لتتبع العقود المنتهية والملغية، وشاشة للعقارات الشاغرة لمتابعة
                                وتسجيل الوحدات غير المؤجرة.
                            </p>

                            <h4><strong>699 ر.س. شهريا</strong></h4>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-12">

                        <div class="card text-center p-3">

                            <h6><strong>اشتراك الشركات</strong></h6>

                            <p>
                                "الحزمة المثالية لشركات العقارات التي تعمل في مجال إدارة الأملاك العقارية والتي تتمتع بفريق
                                متخصص يتألف من عشرة موظفين. تتميز الحزمة ببوابات الخدمات الذاتية لتسهيل التواصل مع المالك
                                والمستأجر، بالإضافة إلى تقارير مجمعة وخدمات الربط مع الأنظمة المختلفة وتمكينهم من إنشاء عروض
                                الأسعار. وتشمل أيضًا تنظيم الصلاحيات مثل السداد اللاحق، مع دعم متنوع وقوائم مالية شاملة
                                تتضمن قائمة العائدات، والتدفقات النقدية، والمركز المالي، وتغييرات في حقوق الملكية."
                            </p>

                            <h4><strong>999 ر.س. شهريا</strong></h4>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-12">

                        <div class="card text-center p-3">

                            <h5 class="text-dark text-warning"><strong>باقة المؤسسات</strong></h5>

                            <p>
                                صممت هذه الباقة لتلبية احتياجات العقاريين والملاك الأفراد وأصحاب المكاتب الناشئة، إذ تٌمكنهم
                                من إدارة تحصيلات ومستحقات العقود، ومتابعة مصروفات العقار مع تنبيهات الدفعات وإنشاء سندات
                                القبض آليًا، وإصدار الفواتير الإلكترونية المتوافقة مع معايير الهيئة، كما تزودهم بخاصيتي
                                إخلاء الوحدات وتجديد العقود، كل هذا بإضافة عدد غير محدود من العقارات والوحدات، وعدد لا نهائي
                                من العقود والمستأجرين.
                            </p>

                            <h4><strong>1399 ر.س. شهريا</strong></h4>
                        </div>

                    </div>
                </div>

                <div class="text-center">
                    <a href="#" class="btn btn-success btn-initial mt-5">
                        <i class="fab fa-buffer"></i>
                        <span class="btn-text">المقارنة بين الباقات</span>
                    </a>
                </div>

            </div>
        </div>

    </section>

    <section class="partners p-5" id="partners">
        <h2 class="title"> شركاؤنا </h2>

        <div class="row">
            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/1.svg')}}" alt="client logo" class="img-fluid">
            </div>

            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/2.png')}}" alt="client logo" class="img-fluid">
            </div>

            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/3.png')}}" alt="client logo" class="img-fluid">
            </div>

            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/4.png')}}" alt="client logo" class="img-fluid">
            </div>

            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/5.svg')}}" alt="client logo" class="img-fluid">
            </div>

            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/6.svg')}}" alt="client logo" class="img-fluid">
            </div>

            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/7.svg')}}" alt="client logo" class="img-fluid">
            </div>

            <div class="col-md-3 col-sm-6">
                <img src="{{asset('assets/images/partners/8.svg')}}" alt="client logo" class="img-fluid">
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var sliderWrapper = $(".slider-wrapper");
            var items = $(".slider-item");
            var itemWidth = items.width();
            var currentIndex = 0;

            // Adjust the width of the slider wrapper
            sliderWrapper.width(items.length * itemWidth);

            // Function to move the slider to the next item
            function nextItem() {
                if (currentIndex < items.length - 1) {
                    currentIndex++;
                    updateSlider();
                }
            }

            // Function to move the slider to the previous item
            function prevItem() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateSlider();
                }
            }

            // Function to update the slider position
            function updateSlider() {
                var translateValue = -currentIndex * itemWidth;
                sliderWrapper.css("transform", "translateX(" + translateValue + "px)");
            }

            // Add event listeners for the next and previous buttons
            $("#nextBtn").on("click", nextItem);
            $("#prevBtn").on("click", prevItem);
        });
    </script>
@endpush
