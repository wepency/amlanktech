@extends('Frontend.Layouts.Login')

@section('title', 'تسجيل الدخول | موقع اتحاد الملاك')

@section('content')
    <div class="login-page-wrap">
        <div class="content-wrap">
            <div class="login-content">
                <div class="item-logo">
                    <a href="#"><img src="/assets/images/logo.png" style="max-width: 250px" alt="logo"></a>
                </div>

                @include('Frontend.Partials._messages')

                <div class="login-form-wrap">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#login-tab" role="tab"
                               aria-selected="true"><i class="icofont-users-alt-4"></i> تسجيل الدخول </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#registration-tab" role="tab"
                               aria-selected="false"><i class="icofont-download"></i> التسجيل </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                       @include('Frontend.Partials.MemberLogin')
                       @include('Frontend.Partials.MemberRegister')


                    </div>
                </div>
            </div>

            <div class="map-line">
                <img src="/media/banner/map_line.png" alt="map">

                <ul class="map-marker">
                    <li><img src="media/banner/marker_1.png" alt="marker"></li>
                    <li><img src="media/banner/marker_2.png" alt="marker"></li>
                    <li><img src="media/banner/marker_3.png" alt="marker"></li>
                    <li><img src="media/banner/marker_4.png" alt="marker"></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        checkIfAcceptTerms();

        @if(old('association_id'))
            getAssociationFees({{old('association_id')}})
        @endif

        $('#ownership_type').change(function () {
            if ($(this).val() == 'group') {
                $('#ownership_ratio_group').removeClass('d-none');
            }else {
                $('#ownership_ratio_group').addClass('d-none');
            }
        })

        $('#validationFormCheck').on('change', function () {
            checkIfAcceptTerms();
        })

        function checkIfAcceptTerms() {
            if ($('#validationFormCheck').is(':checked')) {
                $('#registration-btn').prop('disabled', false);
            }else {
                $('#registration-btn').prop('disabled', true);
            }
        }

        $('#association_id').on('change', function () {
            if(this.value != '') {
                getAssociationFees(this.value);
            }else {
                $('#association_fees_amount').addClass('d-none');
            }
        })

        function getAssociationFees(value) {
            $.get('/api/getAssociationFeesLabel/'+value, function (data) {
                $('#association_fees_amount').removeClass('d-none');
                $('#association_fees_amount .text').text(data.text)
            })
        }
    </script>
@endpush
