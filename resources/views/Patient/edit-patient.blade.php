@extends('layouts.admin-layout')

@section('name')
    {{ $data['employeeFirstname'] . ' ' . $data['employeeLastname'] }}
@endsection

@section('employee_image')
    @if ($data['employee_image'] != null || $data['employee_image'] != '')
        <img src="../../../app-assets/images/employees/{{ $data['employee_image'] }}" alt="avatar">
    @else
        <img src="../../../app-assets/images/profiles/profilepic.jpg" alt="default avatar">
    @endif
@endsection

@section('content')
    <style>
        .table td {
            font-size: 11px;
        }

        .table th,
        .table td {
            padding: 0.5rem;
        }

        .exam-done {
            color: #156f29 !important;
            font-weight: 600 !important;
        }

        .other-specify-con {
            display: none;
        }

        .to_upper {
            text-transform: uppercase;
        }

        .remove {
            display: none;
        }

        .prescription-group {
            display: none;
        }
        .show-med {
            display: block !important;
        }
    </style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- users view start -->
                @if (Session::get('yellow_card_success'))
                    <script>
                        window.open('/yellow_card_print?id={{ $patient->id }}', 'wp', 'width=1000,height=800');
                    </script>
                @endif
                <div class="row">
                    <div class="col-xl-9 order-lg-2 order-xl-1 order-sm-2 order-xs-2 col-lg-12">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                aria-labelledby="account-pill-general" aria-expanded="true">
                                <section class="users-view">
                                    <!-- users view media object start -->
                                    <div class="row bg-white p-2">
                                        @if (Session::get('status'))
                                            @push('scripts')
                                                <script>
                                                    toastr.success('{{ Session::get('status') }}', 'Success');
                                                </script>
                                            @endpush
                                        @endif
                                        @if (Session::get('fail'))
                                            @push('scripts')
                                                <script>
                                                    toastr.error('{{ Session::get('fail') }}', 'Failed');
                                                </script>
                                            @endpush
                                        @endif
                                        <div class="col-md-10">
                                            <h3>Medical Records</h3>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($patientRecords as $record)
                                                        <div class="my-50">
                                                            @if($patient->created_date != $record->created_date ? 'active' : null && session()->get('dept_id') == '1')
                                                                <button type="button" class="btn btn-danger remove-patient-record-btn" id="{{ $record->id }}">Remove</button>
                                                            @endif
                                                            <button
                                                                onclick="location.href = 'patient_edit?id={{ $record->id }}&patientcode={{ $record->patientcode }}'"
                                                                class="btn btn-outline-secondary mr-1 {{ $patient->created_date == $record->created_date ? 'active' : null }}">
                                                                {{ date_format(new DateTime($record->created_date), 'F d, Y h:i A') }}</button>
                                                        </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @if ($admissionPatient)
                                                <h3
                                                    class="font-bold badge p-1 float-right {{ $admissionPatient->admit_type == 'Normal' ? 'badge-secondary' : 'badge-warning' }}">
                                                    {{ $admissionPatient->admit_type }} Patient</h3>
                                            @endif
                                        </div>
                                    </div>
                                    @yield('content')
                                    <div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel18" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel18"><i class="fa fa-camera"></i>
                                                        Take Picture
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body d-flex justify-content-center align-items-center">
                                                    <div class="camera"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn grey btn-outline-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-outline-primary"
                                                        onclick="snapShot()">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <ul class="nav nav-tabs nav-linetriangle" role="tablist">
                                                        <li class="nav-item main-tab">
                                                            <a class="nav-link @php echo session()->get('dept_id') == " 1"
                                                            || session()->get('dept_id') == "17"
                                                            ? "active" : "" @endphp"
                                                                id="baseIcon-tab31" data-toggle="tab"
                                                                aria-controls="tabIcon31" href="#tabIcon31"
                                                                role="tab"><i class="fa fa-user"></i>User
                                                                Info</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link main-tab" id="baseIcon-tab32"
                                                                data-toggle="tab" aria-controls="tabIcon32"
                                                                href="#tabIcon32" role="tab"><i class="fa fa-globe"></i>
                                                                Agency Info</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link main-tab" id="baseIcon-tab33"
                                                                data-toggle="tab" aria-controls="tabIcon33"
                                                                href="#tabIcon33" role="tab"><i
                                                                    class="fa fa-list-alt"></i>Medical History</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link main-tab" id="baseIcon-tab34"
                                                                data-toggle="tab" aria-controls="tabIcon34"
                                                                href="#tabIcon34" role="tab"><i
                                                                    class="fa fa-bars"></i>Declaration Form</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link main-tab {{ session()->get('dept_id') != ' 1' ? 'active' : '' }}"
                                                                id="baseIcon-tab35" data-toggle="tab"
                                                                aria-controls="tabIcon35" href="#tabIcon35"
                                                                role="tab"><i class="fa fa-file"></i>Basic & Special
                                                                Exams</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link main-tab" id="baseIcon-tab36"
                                                                data-toggle="tab" aria-controls="tabIcon36"
                                                                href="#tabIcon36" role="tab"><i
                                                                    class="fa fa-file"></i>Lab Exams</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content px-1 pt-1">
                                                        <div class="tab-pane main-content @php echo session()->get('dept_id') == " 1" ? "active" : "" @endphp"
                                                            id="tabIcon31" role="tabpanel"
                                                            aria-labelledby="baseIcon-tab31">
                                                            @include('Patient.edit-patient-form.edit-patient-general')
                                                        </div>
                                                        <div class="tab-pane main-content" id="tabIcon32" role="tabpanel"
                                                            aria-labelledby="baseIcon-tab32">
                                                            @include('Patient.edit-patient-form.edit-patient-agency')
                                                        </div>
                                                        <div class="tab-pane main-content" id="tabIcon33" role="tabpanel"
                                                            aria-labelledby="baseIcon-tab33">
                                                            @include('Patient.medical_history', [$medicalHistory])
                                                        </div>
                                                        <div class="tab-pane main-content" id="tabIcon34" role="tabpanel"
                                                            aria-labelledby="baseIcon-tab34">
                                                            @if ($declarationForm == null)
                                                                <h3 class="text-center font-weight-regular my-2">No Record Found</h3>
                                                            @else
                                                                @include('Patient.edit-patient-form.edit-patient-dec')
                                                            @endif
                                                        </div>
                                                        <div class="tab-pane main-content @php echo session()->get('dept_id') != " 1" &&
                                                        session()->get('dept_id') != "17" && session()->get('dept_id') != "8" ? "active" : "" @endphp"
                                                            id="tabIcon35" role="tabpanel"
                                                            aria-labelledby="baseIcon-tab35">
                                                            <div class="col-12">
                                                                @if (!$admissionPatient)
                                                                    <div
                                                                        class="container d-flex justify-content-center align-items-center flex-column">
                                                                        <h3 class="text-center font-weight-regular my-2">
                                                                            Before entering this section, the patient needs
                                                                            to
                                                                            admit.
                                                                        </h3>
                                                                        <button id="admission-btn"
                                                                            class="btn btn-solid btn-primary text-center">Admit
                                                                            Now</button>
                                                                    </div>
                                                                @else
                                                                    <div class="nav-vertical">
                                                                        <ul class="nav nav-tabs nav-left nav-border-left"
                                                                            id="child-basic-tabs" role="tablist">
                                                                            <h4 class="font-weight-bold">Basic Exams</h4>
                                                                            @if (session()->get('dept_id') == '7' ||
                                                                                    session()->get('dept_id') == '1' ||
                                                                                    session()->get('dept_id') == '8' ||
                                                                                    session()->get('dept_id') == '6')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_physical ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab9" data-toggle="tab" href="#tabVerticalLeft9">Physical Exam
                                                                                    </a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '14' ||
                                                                                    session()->get('dept_id') == '1' ||
                                                                                    session()->get('dept_id') == '8' ||
                                                                                    session()->get('dept_id') == '6')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_visacuity ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab16" data-toggle="tab" href="#tabVerticalLeft16">Visual Acuity
                                                                                    </a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '9' || session()->get('dept_id') == '1' || session()->get('dept_id') == '8')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_dental ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab4" data-toggle="tab" href="#tabVerticalLeft4">Dental</a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '5' || session()->get('dept_id') == '1' || session()->get('dept_id') == '8')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_psycho ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab10" data-toggle="tab" href="#tabVerticalLeft10">Psychological</a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '15' || session()->get('dept_id') == '1' ||session()->get('dept_id') == '6' ||
                                                                                    session()->get('dept_id') == '8')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_audio ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab1"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft1"
                                                                                        href="#tabVerticalLeft1"
                                                                                        >Audiometry</a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '14' || session()->get('dept_id') == '1' || session()->get('dept_id') == '8' ||
                                                                                    session()->get('dept_id') == '6')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_ishihara ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab8" data-toggle="tab" href="#tabVerticalLeft8">Ishihara</a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '4' || session()->get('dept_id') == '1' || session()->get('dept_id') == '8')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_xray ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab18" data-toggle="tab" href="#tabVerticalLeft18">X-Ray
                                                                                    </a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '16' ||
                                                                                    session()->get('dept_id') == '1' ||
                                                                                    session()->get('dept_id') == '6' ||
                                                                                    session()->get('dept_id') == '8')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_ecg ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab5"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft5"
                                                                                        href="#tabVerticalLeft5"
                                                                                        >ECG
                                                                                    </a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '16' ||
                                                                                    session()->get('dept_id') == '1' ||
                                                                                    session()->get('dept_id') == '8' ||
                                                                                    session()->get('dept_id') == '6' ||
                                                                                    session()->get('dept_id') == '7')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_ppd ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab17"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft17"
                                                                                        href="#tabVerticalLeft17"
                                                                                        >PPD TEST
                                                                                    </a>
                                                                                </li>
                                                                            @endif

                                                                            @if (session()->get('dept_id') == '16' ||
                                                                                    session()->get('dept_id') == '1' ||
                                                                                    session()->get('dept_id') == '8' ||
                                                                                    session()->get('dept_id') == '6' ||
                                                                                    session()->get('dept_id') == '7')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_crf ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab2" data-toggle="tab" href="#tabVerticalLeft2">Cardiac Risk Factor / <br> Spirometry </a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_cardio ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab3" data-toggle="tab" href="#tabVerticalLeft3">Cardiovascular</a>
                                                                                </li>
                                                                            @endif

                                                                            <h4 class="font-weight-bold">Special Exams</h4>

                                                                            @if (session()->get('dept_id') == '16' ||
                                                                                    session()->get('dept_id') == '1' ||
                                                                                    session()->get('dept_id') == '8' ||
                                                                                    session()->get('dept_id') == '6' ||
                                                                                    session()->get('dept_id') == '6' ||
                                                                                    session()->get('dept_id') == '7')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_echodoppler ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab6" data-toggle="tab" aria-controls="tabVerticalLeft6" href="#tabVerticalLeft6">
                                                                                        2D Echo Doppler 
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_echoplain ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab7" data-toggle="tab"  href="#tabVerticalLeft7">
                                                                                        2D Echo Plain 
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_stressecho ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab12"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft12"
                                                                                        href="#tabVerticalLeft12"
                                                                                        >Stress
                                                                                        Echo </a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_stresstest ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab13"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft13"
                                                                                        href="#tabVerticalLeft13"
                                                                                        >Stress
                                                                                        Test </a>
                                                                                </li>
                                                                            @endif

                                                                            <li
                                                                                class="nav-item vertical-tab-border d-none">
                                                                                <a class="nav-link child-basic-tab nav-link-width {{ $exam_psychobpi ? 'exam-done' : null }}"
                                                                                    id="baseVerticalLeft1-tab11"
                                                                                    data-toggle="tab"
                                                                                    aria-controls="tabVerticalLeft11"
                                                                                    href="#tabVerticalLeft11"
                                                                                    role="tab"
                                                                                    aria-selected="false">BPI
                                                                                    Psycho </a>
                                                                            </li>


                                                                            @if (session()->get('dept_id') == '4' || session()->get('dept_id') == '1' || session()->get('dept_id') == '8')
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-basic-tab nav-link-width {{ $exam_ultrasound ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab14"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft14"
                                                                                        href="#tabVerticalLeft14"
                                                                                        >Ultrasound</a>
                                                                                </li>
                                                                            @endif



                                                                        </ul>
                                                                        <div class="tab-content px-1">
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft1" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab1">
                                                                                @if (!$exam_audio)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_audiometry?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'Audiometry.view-audiometry',
                                                                                        [$exam_audio]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft2" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab2">
                                                                                <div class="row">
                                                                                    @if (!$exam_crf)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient
                                                                                                    has
                                                                                                    no
                                                                                                    record
                                                                                                    in
                                                                                                    this exam. Do you want
                                                                                                    to add a
                                                                                                    record?
                                                                                                </h2>
                                                                                                <a href="/add_crf?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'CardiacRiskFactor.view-crf',
                                                                                            [$exam_crf]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft3" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab3">
                                                                                @if (!$exam_cardio)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_cardiovascular?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'CardioVascular.view-cardiovascular',
                                                                                        [$exam_cardio]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft4" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab4">
                                                                                @if (!$exam_dental)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_dental?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'Dental.view-dental',
                                                                                        [$exam_dental]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft5" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab5">
                                                                                @if (!$exam_ecg)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_ecg?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'ECG.view-ecg',
                                                                                        [$exam_ecg]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft17" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab17">
                                                                                @if (!$exam_ppd)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_ppd?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'PPD.view-ppd',
                                                                                        [$exam_ppd]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content my-1"
                                                                                id="tabVerticalLeft6" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab6">
                                                                                @if (!$exam_echodoppler)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_echodoppler?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'EchoDoppler.view-echodoppler',
                                                                                        [$exam_echodoppler]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content my-1"
                                                                                id="tabVerticalLeft7" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab7">
                                                                                @if (!$exam_echoplain)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_echoplain?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'EchoPlain.view-echoplain',
                                                                                        [$exam_echoplain]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content my-1"
                                                                                id="tabVerticalLeft8" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab8">
                                                                                @if (!$exam_ishihara)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_ishihara?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'Ishihara.view-ishihara',
                                                                                        [$exam_ishihara]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            @if (session()->get('dept_id') == '1' ||
                                                                                    session()->get('dept_id') == '7' ||
                                                                                    session()->get('dept_id') == '8' ||
                                                                                    session()->get('dept_id') == '6')
                                                                                <div class="tab-pane child-basic-content my-1"
                                                                                    id="tabVerticalLeft9" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab9">
                                                                                    @if (!$exam_physical)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_physical?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Physical.view-physical',
                                                                                            [$exam_physical]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft10" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab10">
                                                                                @if (!$exam_psycho)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_psycho?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'Psychological.view-psycho',
                                                                                        [$exam_psycho]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft11" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab11">
                                                                                @if (!$exam_psychobpi)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_psychobpi?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'PsychoBPI.view-psychobpi',
                                                                                        [$exam_psychobpi]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft12" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab12">
                                                                                @if (!$exam_stressecho)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_stressecho?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'StressEcho.view-stressecho',
                                                                                        [$exam_stressecho]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft13" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab13">
                                                                                @if (!$exam_stresstest)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_stresstest?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'StressTest.view-stresstest',
                                                                                        [$exam_stresstest]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content @php echo session()->get('dept_id') == "
                                                                        4" ? "active" : "" @endphp"
                                                                                id="tabVerticalLeft14" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab14">
                                                                                @if (!$exam_ultrasound)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_ultrasound?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'Ultrasound.view-ultrasound',
                                                                                        [$exam_ultrasound]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft16" role="tabpanel"
                                                                                varia-labelledby="baseVerticalLeft1-tab16">
                                                                                @if (!$exam_visacuity)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_visacuity?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'Visacuity.view-visacuity',
                                                                                        [$exam_visacuity]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                            <div class="tab-pane child-basic-content"
                                                                                id="tabVerticalLeft18" role="tabpanel"
                                                                                aria-labelledby="baseVerticalLeft1-tab18">
                                                                                @if (!$exam_xray)
                                                                                    <div class="container">
                                                                                        <div
                                                                                            class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                            <h2 class="text-center">This
                                                                                                patient has
                                                                                                no
                                                                                                record in
                                                                                                this
                                                                                                exam. Do you want to add a
                                                                                                record?
                                                                                            </h2>
                                                                                            <a href="/add_xray?id={{ $admissionPatient->id }}"
                                                                                                class="btn btn-solid btn-primary te">Add</a>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    @include(
                                                                                        'XRay.view-xray',
                                                                                        [$exam_xray]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane main-content" id="tabIcon36" role="tabpanel"
                                                            aria-labelledby="baseIcon-tab36">
                                                            <div class="col-md-12">
                                                                @if ($admissionPatient == null)
                                                                    <div
                                                                        class="container d-flex justify-content-center align-items-center flex-column">
                                                                        <h3 class="text-center font-weight-regular my-2">
                                                                            Before entering this section, the patient needs
                                                                            to
                                                                            admit.
                                                                        </h3>
                                                                        <a href="create_admission?id={{ $patient->id }}&patientcode={{ $patient->patientcode }}"
                                                                            class="btn btn-solid btn-primary text-center">Admit
                                                                            Now</a>
                                                                    </div>
                                                                @else
                                                                    <div class="nav-vertical">
                                                                        @if (session()->get('dept_id') == '3' || session()->get('dept_id') == '1' || session()->get('dept_id') == '8')
                                                                            <ul class="nav nav-tabs nav-left nav-border-left"
                                                                                role="tablist">
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_hema ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab25"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft25"
                                                                                        href="#tabVerticalLeft25"
                                                                                        >Hematology
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_urin ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab28"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft28"
                                                                                        href="#tabVerticalLeft28"
                                                                                        >Urinalysis</a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_pregnancy ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab27"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft27"
                                                                                        href="#tabVerticalLeft27"
                                                                                        >Pregnancy</a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_feca ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab24"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft24"
                                                                                        href="#tabVerticalLeft24"
                                                                                        >Fecalysis</a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width  {{ $exam_blood_serology ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab21"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft21"
                                                                                        href="#tabVerticalLeft21"
                                                                                        role="tab"
                                                                                        aria-selected="true">Blood
                                                                                        Chemistry</a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_hepa ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab26"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft26"
                                                                                        href="#tabVerticalLeft26"
                                                                                        >Serology</a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_hiv ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab22"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft22"
                                                                                        href="#tabVerticalLeft22"
                                                                                        >HIV</a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_drug ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab23"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft23"
                                                                                        href="#tabVerticalLeft23"
                                                                                        >Drug
                                                                                        Test</a>
                                                                                </li>
                                                                                <li class="nav-item vertical-tab-border">
                                                                                    <a class="nav-link child-lab-tab nav-link-width {{ $examlab_misc ? 'exam-done' : null }}"
                                                                                        id="baseVerticalLeft1-tab29"
                                                                                        data-toggle="tab"
                                                                                        aria-controls="tabVerticalLeft29"
                                                                                        href="#tabVerticalLeft29"
                                                                                        >Miscellaneous</a>
                                                                                </li>
                                                                            </ul>
                                                                            <div class="tab-content px-1">
                                                                                <div class="tab-pane"
                                                                                    id="tabVerticalLeft21"
                                                                                    role="tabpanel child-lab-content"
                                                                                    aria-labelledby="baseVerticalLeft1-tab21">
                                                                                    @if (!$exam_blood_serology)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_bloodsero?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include('Blood_Serology.view-bloodserology')
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft22" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab22">
                                                                                    @if (!$examlab_hiv)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_hiv?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'HIV.view-hiv',
                                                                                            [$examlab_hiv]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft23" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab23">
                                                                                    @if (!$examlab_drug)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_drug?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Drug.view-drug',
                                                                                            [$examlab_drug]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft24" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab24">
                                                                                    @if (!$examlab_feca)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_fecalysis?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Fecalysis.view-fecalysis',
                                                                                            [$examlab_feca]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft25" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab25">
                                                                                    @if (!$examlab_hema)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_hematology?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Hematology.view-hematology',
                                                                                            [$examlab_hema]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft26" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab26">
                                                                                    @if (!$examlab_hepa)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_hepatitis?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Hepatitis.view-hepatitis',
                                                                                            [$examlab_hepa]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft27" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab27">
                                                                                    @if (!$examlab_pregnancy)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_pregnancy?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Pregnancy.view-pregnancy',
                                                                                            [$examlab_pregnancy]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft28" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab28">
                                                                                    @if (!$examlab_urin)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_urinalysis?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Urinalysis.view-urinalysis',
                                                                                            [$examlab_urin]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                                <div class="tab-pane child-lab-content"
                                                                                    id="tabVerticalLeft29" role="tabpanel"
                                                                                    aria-labelledby="baseVerticalLeft1-tab29">
                                                                                    @if (!$examlab_misc)
                                                                                        <div class="container">
                                                                                            <div
                                                                                                class="container d-flex justify-content-center align-items-center my-3 flex-column">
                                                                                                <h2 class="text-center">
                                                                                                    This patient has
                                                                                                    no
                                                                                                    record in
                                                                                                    this
                                                                                                    exam. Do you want to add
                                                                                                    a record?
                                                                                                </h2>
                                                                                                <a href="/add_misc?id={{ $admissionPatient->id }}"
                                                                                                    class="btn btn-solid btn-primary te">Add</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        @include(
                                                                                            'Miscellaneous.view-misc',
                                                                                            [$examlab_misc]
                                                                                        )
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div role="tabpanel" class="tab-pane false" id="account-vertical-referral" aria-labelledby="account-pill-referral" aria-expanded="false">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title" id="basic-layout-form">Edit Referral Slip</h4>
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            @if($referral)
                                                @include('Referral.ReferralForms.edit-form')
                                            @else
                                                <div class="h4 text-center">No Referral Slip Found</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-invoice" role="tabpanel"
                                aria-labelledby="account-pill-invoice" aria-expanded="false">
                                <div class="card">
                                    @if ($patient_or)
                                        @include('Patient.edit-patient-invoice', [
                                            $patient,
                                            $patientInfo,
                                            $exam_groups,
                                            $patient_package,
                                            $patient_or,
                                        ])
                                    @else
                                        @include('Patient.add-patient-invoice', [
                                            $patient,
                                            $patientInfo,
                                            $exam_groups,
                                            $patient_package,
                                            $admissionPatient,
                                        ])
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-password" role="tabpanel"
                                aria-labelledby="account-pill-password" aria-expanded="false">
                                <div class="card">
                                    <div class="card-body">
                                        @if ($latest_schedule)
                                            <form action='/update_schedule' method="POST">
                                                @csrf
                                                <h4 class="form-section"><i class="feather icon-user"></i>Re Schedule</h4>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="patient_id"
                                                            value="{{ $latest_schedule->patient_id }}">
                                                        <input type="hidden" name="patientcode"
                                                            value="{{ $latest_schedule->patientcode }}">
                                                        <input type="hidden" name="id"
                                                            value="{{ $latest_schedule->id }}">
                                                        <input type="date" max="2050-12-31" class="form-control"
                                                            value="{{ $latest_schedule->date }}" name="schedule_date">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save Changes</button>
                                                </div>
                                                <input type="hidden" name="action" value="admin_update">
                                            </form>
                                        @else
                                            <form action='/store_schedule' method="POST">
                                                @csrf
                                                <h4 class="form-section"><i class="feather icon-user"></i>Add Schedule
                                                </h4>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="patient_id"
                                                            value="{{ $patient->id }}">
                                                        <input type="hidden" name="patientcode"
                                                            value="{{ $patient->patientcode }}">
                                                        <input type="date" max="2050-12-31" class="form-control"
                                                            value="" name="schedule_date">
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                        changes</button>
                                                </div>
                                                <input type="hidden" name="action" value="admin_store">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($admissionPatient)
                                <div class="tab-pane fade" id="account-vertical-follow" role="tabpanel"
                                    aria-labelledby="account-pill-follow" aria-expanded="false">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <div class="card-title">
                                                Follow Up Form
                                            </div>
                                            <div>
                                                <a class="btn btn-secondary text-white"
                                                    id="account-pill-connections"data-toggle="pill"
                                                    onclick="window.open('/default_follow_up_print?id={{ $patient->id }}&admission_id={{ $admissionPatient->id }}&action=print')"
                                                    aria-expanded="false">
                                                    <i class="fa fa-print"></i>
                                                    Print Default Follow Up Form
                                                </a>
                                                <a class="btn btn-secondary text-white"
                                                    id="account-pill-connections"data-toggle="pill"
                                                    onclick="window.open('/follow_up_print?id={{ $patient->id }}&admission_id={{ $admissionPatient->id }}&action=print')"
                                                    aria-expanded="false">
                                                    <i class="fa fa-print"></i>
                                                    Print Follow Up Form
                                                </a>
                                                
                                                <a onclick="window.open('/follow_up_print?id={{ $patient->id }}&admission_id={{ $admissionPatient->id }}&action=download')"
                                                    class="btn btn-secondary text-white"><i class="fa fa-download"></i>
                                                    Download Follow Up Form</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" role="tablist">
                                                @forelse($followup_records as $key => $followup_record)
                                                    @if ($loop->first)
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="{{ $key }}"
                                                                data-toggle="tab" aria-controls="fl{{ $key }}"
                                                                href="#fl{{ $key }}" role="tab"
                                                                aria-selected="true">{{ date_format(new DateTime($admissionPatient->trans_date), 'F d, Y') }}</a>
                                                        </li>
                                                    @else
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="{{ $key }}"
                                                                data-toggle="tab" aria-controls="fl{{ $key }}"
                                                                href="#fl{{ $key }}" role="tab"
                                                                aria-selected="true">{{ date_format(new DateTime($followup_record->date), 'F d, Y') }}</a>
                                                        </li>
                                                    @endif

                                                @empty
                                                @endforelse
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="new_followup" data-toggle="tab"
                                                        aria-controls="new_followup1" href="#new_followup1"
                                                        role="tab" aria-selected="true">New Follow Up</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content px-1 pt-1">
                                                @forelse($followup_records as $key => $followup_record)
                                                    <div class="tab-pane" id="fl{{ $key }}" role="tabpanel"
                                                        aria-labelledby="{{ $key }}">
                                                        @php
                                                            $findings = explode(';', $followup_record->findings);
                                                            $recommendations = explode(';', $followup_record->remarks);
                                                        @endphp
                                                        <div class="my-1">
                                                            <button type="button" class="btn btn-danger delete-followup"
                                                                id="{{ $followup_record->id }}"><i
                                                                    class="fa fa-trash"></i> Delete This Record</button>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="p-1 border">
                                                                    <h3 class="font-weight-bold">Findings</h3>
                                                                    <div class="row">
                                                                        @foreach ($findings as $finding)
                                                                            <div class="col-md-6 my-50">
                                                                                @php echo nl2br($finding) @endphp
                                                                            </div>
                                                                        @endforeach
                                                                        @if ($exam_ecg)
                                                                            @if ($exam_ecg->ecg == 'Significant Findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    ECG: @php echo nl2br($exam_ecg->remarks) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                        @if ($exam_xray)
                                                                            @if ($exam_xray->chest_remarks_status == 'findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    Chest Xray: @php echo nl2br($exam_xray->chest_findings) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                        @if ($exam_xray)
                                                                            @if ($exam_xray->lumbosacral_remarks_status == 'findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    Lumbosacral Xray: @php echo nl2br($exam_xray->lumbosacral_findings) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                        @if ($exam_xray)
                                                                            @if ($exam_xray->knees_remarks_status == 'findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    Knees Xray
                                                                                    @php echo nl2br($exam_xray->knees_findings) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="p-1 border">
                                                                    <h3 class="font-weight-bold">Recommendations</h3>
                                                                    <div class="row">
                                                                        @foreach ($recommendations as $recommendation)
                                                                            <div class="col-md-6 my-50">
                                                                                @php echo nl2br($recommendation) @endphp
                                                                            </div>
                                                                        @endforeach
                                                                        @if ($exam_ecg)
                                                                            @if ($exam_ecg->ecg == 'Significant Findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    ECG: @php echo nl2br($exam_ecg->recommendation) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                        @if ($exam_xray)
                                                                            @if ($exam_xray->chest_remarks_status == 'findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    Chest Xray: @php echo nl2br($exam_xray->chest_recommendations) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                        @if ($exam_xray)
                                                                            @if ($exam_xray->lumbosacral_remarks_status == 'findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    Lumbosacral Xray: @php echo nl2br($exam_xray->lumbosacral_recommendations) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                        @if ($exam_xray)
                                                                            @if ($exam_xray->knees_remarks_status == 'findings')
                                                                                <div class="col-md-6 my-50">
                                                                                    Knees Xray
                                                                                    @php echo nl2br($exam_xray->knees_recommendations) @endphp
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                @endforelse
                                                <div class="tab-pane active" id="new_followup1" role="tabpanel"
                                                    aria-labelledby="new_followup">
                                                    <form action="/create_followup" method="post">
                                                        @csrf
                                                        <input type="hidden" name="patient_id"
                                                            value="{{ $patient->id }}">
                                                        <input type="hidden" name="admission_id"
                                                            value="{{ $admissionPatient->id }}">
                                                        <div class="row p-1">
                                                            <div class="col-md-12 col-lg-8">
                                                                <div class="nav-vertical">
                                                                    <ul class="nav nav-tabs nav-left nav-border-left"
                                                                        id="child-basic-tabs" role="tablist">
                                                                        <li class="nav-item vertical-tab-border">
                                                                            <a class="nav-link child-basic-tab nav-link-width active"
                                                                                id="patient-findings32" data-toggle="tab"
                                                                                aria-controls="patient-findings"
                                                                                href="#patient-findings" role="tab"
                                                                                aria-selected="false">Findings</a>
                                                                        </li>
                                                                        <li class="nav-item vertical-tab-border">
                                                                            <a class="nav-link child-basic-tab nav-link-width"
                                                                                id="patient-recommendations32"
                                                                                data-toggle="tab"
                                                                                aria-controls="patient-recommendations"
                                                                                href="#patient-recommendations"
                                                                                role="tab"
                                                                                aria-selected="false">Reccomendation</a>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="tab-content px-1">
                                                                        <div class="tab-pane active in"
                                                                            id="patient-findings"
                                                                            aria-labelledby="patient-findings32"
                                                                            role="tabpanel">
                                                                            @include(
                                                                                'Patient.patient_findings',
                                                                                [
                                                                                    $exam_audio,
                                                                                    $exam_cardio,
                                                                                    $exam_ecg,
                                                                                    $exam_echodoppler,
                                                                                    $exam_echoplain,
                                                                                    $exam_ishihara,
                                                                                    $exam_psycho,
                                                                                    $exam_ppd,
                                                                                    $exam_physical,
                                                                                    $exam_psychobpi,
                                                                                    $exam_stressecho,
                                                                                    $exam_stresstest,
                                                                                    $exam_ultrasound,
                                                                                    $exam_dental,
                                                                                    $exam_xray,
                                                                                    $exam_blood_serology,
                                                                                    $examlab_hiv,
                                                                                    $examlab_drug,
                                                                                    $examlab_feca,
                                                                                    $examlab_hema,
                                                                                    $examlab_hepa,
                                                                                    $examlab_urin,
                                                                                    $examlab_pregnancy,
                                                                                    $examlab_misc,
                                                                                ]
                                                                            )
                                                                        </div>
                                                                        <div class="tab-pane" id="patient-recommendations"
                                                                            aria-labelledby="patient-recommendations32"
                                                                            role="tabpanel">
                                                                            @include(
                                                                                'Patient.patient_recommendations',
                                                                                [
                                                                                    $exam_audio,
                                                                                    $exam_cardio,
                                                                                    $exam_ecg,
                                                                                    $exam_echodoppler,
                                                                                    $exam_echoplain,
                                                                                    $exam_ishihara,
                                                                                    $exam_psycho,
                                                                                    $exam_ppd,
                                                                                    $exam_physical,
                                                                                    $exam_psychobpi,
                                                                                    $exam_stressecho,
                                                                                    $exam_stresstest,
                                                                                    $exam_ultrasound,
                                                                                    $exam_dental,
                                                                                    $exam_xray,
                                                                                    $exam_blood_serology,
                                                                                    $examlab_hiv,
                                                                                    $examlab_drug,
                                                                                    $examlab_feca,
                                                                                    $examlab_hema,
                                                                                    $examlab_hepa,
                                                                                    $examlab_urin,
                                                                                    $examlab_pregnancy,
                                                                                    $examlab_misc,
                                                                                ]
                                                                            )
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-4">
                                                                <!-- <div class="container-fluid">
                                                                <a href="" class="btn btn-solid btn-secondary">May 22, 2022</a>
                                                                <a href="" class="btn btn-solid btn-secondary">May 22, 2022</a>
                                                                <a href="" class="btn btn-solid btn-secondary">May 22, 2022</a>
                                                            </div> -->
                                                                <div class="container-fluid my-1">
                                                                    <div class="form-group">
                                                                        <label for=""
                                                                            class="font-weight-bold">Full Name</label>
                                                                        <input type="text" name=""
                                                                            id="" readonly
                                                                            value="{{ $patient->lastname }}, {{ $patient->firstname }} {{ $patient->middlename }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for=""
                                                                            class="font-weight-bold">Patient Code</label>
                                                                        <input type="text" name=""
                                                                            id="" readonly
                                                                            value="{{ $patient->patientcode }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for=""
                                                                            class="font-weight-bold">Date</label>
                                                                        <input type="date" name="date"
                                                                            id="" value="{{ date('Y-m-d') }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    <button class="btn btn-primary float-right">Create
                                                                        Follow Up</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tab3" role="tabpanel"
                                                    aria-labelledby="base-tab3">
                                                    <p>Biscuit ice cream halvah candy canes bear claw ice cream cake
                                                        chocolate bar donut. Toffee cotton candy liquorice. Oat cake lemon
                                                        drops gingerbread dessert caramels. Sweet dessert jujubes powder
                                                        sweet sesame snaps.</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($admissionPatient)
                                <div class="tab-pane fade" id="account-vertical-social" role="tabpanel"
                                    aria-labelledby="account-pill-social" aria-expanded="false">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="card-title">
                                                        <h3>Uploaded Files</h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    @foreach ($errors->all() as $error)
                                                        @push('scripts')
                                                            <script>
                                                                let toaster = toastr.error('{{ $error }}', 'Error');
                                                            </script>
                                                        @endpush
                                                    @endforeach
                                                    <form action="/store_patient_files" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <input type="hidden" name="patient_id"
                                                                    value="{{ $patient->id }}">
                                                                <input type="file" class="form-control"
                                                                    id="upload_files" name="upload_files[]" multiple />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <button class="btn btn-solid btn-primary">Upload</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @if ($patient_upload_files)
                                                    @foreach ($patient_upload_files as $patient_upload_file)
                                                        @if (pathinfo($patient_upload_file->file_name, PATHINFO_EXTENSION) == 'pdf')
                                                            <div class="col-md-2">
                                                                <div class="upload-con">
                                                                    <img src="../../../app-assets/images/pdf.png"
                                                                        alt="">
                                                                    <div class="upload-btn-div">
                                                                        <button type="button"
                                                                            onclick="window.open('/app-assets/files/{{ $patient_upload_file->file_name }}')"
                                                                            class="btn-print">View</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-2">
                                                                <div class="upload-con">
                                                                    <img src="../../../app-assets/files/{{ $patient_upload_file->file_name }}"
                                                                        alt="">
                                                                    <div class="upload-btn-div">
                                                                        <button type="button"
                                                                            onclick="window.open('/app-assets/files/{{ $patient_upload_file->file_name }}')"
                                                                            class="btn-print">View</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <h4><b>CERTIFICATES</b></h4>
                                            <div class="row container my-1">
                                                <div class="col-lg-4 col-xl-3 col-sm-6 ">
                                                    <div class="print-con">
                                                        <img src="../../../app-assets/images/gallery/mlc.png"
                                                            alt="">
                                                        <div class="print-btn-div">
                                                            <button type="button"
                                                                onclick="window.open('/mlc_print?id={{ $admissionPatient->id }}','wp','width=1000,height=800').print();"
                                                                class="btn-print">Print MLC</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-3 col-sm-6 ">
                                                    <div class="print-con">
                                                        <img src="../../../app-assets/images/gallery/bahia.png"
                                                            alt="">
                                                        <div class="print-btn-div">
                                                            <button type="button"
                                                                onclick="window.open('/peme_bahia_print?id={{ $admissionPatient->id }}','wp','width=1000,height=800').print();"
                                                                class="btn-print">Print PEME BAHIA</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-3 col-sm-6 ">
                                                    <div class="print-con">
                                                        <img src="../../../app-assets/images/gallery/mer.png"
                                                            alt="">
                                                        <div class="print-btn-div">
                                                            <button type="button"
                                                                onclick="window.open('/mer_print?id={{ $admissionPatient->id }}','wp','width=1000,height=800').print();"
                                                                class="btn-print">Print MER</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4><b>MEDICAL CERTIFICATE</b></h4>
                                            @include('PrintPanel.print-panel')
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="tab-pane fade" id="account-vertical-info" role="tabpanel"
                                aria-labelledby="account-pill-info" aria-expanded="false">
                                @if ($admissionPatient)
                                    @include('Admission.edit-admission')
                                @else
                                    @include('Admission.add-admission', [
                                        $patient,
                                        $patientInfo,
                                        $list_exams,
                                    ])
                                @endif
                            </div>
                            <div class="tab-pane fade" id="account-vaccination-record" role="tabpanel"
                                aria-labelledby="account-vaccination-record" aria-expanded="false">
                                @include('Patient.yellow_card', [$yellow_card_records])
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 order-lg-1 order-xl-2 order-sm-1 order-xs-1 col-lg-12 position-relative">
                        <div class="row p-50 rounded" style="background: #091a3b">
                            <div class="col-lg-3 col-md-4 col-xl-12">
                                <div class="row my-1">
                                    <div
                                        class="col-md-12 col-xl-5 col-lg-12 d-xl-flex align-items-center justify-content-center">
                                        <button class="btn btn-solid p-0 open-camera" onclick="openCamera()">
                                            @if (
                                                $patient->patient_image == null ||
                                                    $patient->patient_image == '' ||
                                                    !file_exists(public_path('app-assets/images/profiles/') . $patient->patient_image))
                                                <img src="../../../app-assets/images/profiles/profilepic.jpg"
                                                    alt="Profile Picture" data-toggle="modal" data-target="#defaultSize"
                                                    class="users-avatar-shadow rounded" height="110" width="110">
                                            @else
                                                <img src="../../../app-assets/images/profiles/{{ $patient->patient_image . '?' . $patient->updated_date }}"
                                                    data-toggle="modal" data-target="#defaultSize" alt="Profile Picture"
                                                    class="users-avatar-shadow" height="110" width="110">
                                            @endif
                                        </button>
                                    </div>
                                    <div class="col-md-12 col-xl-6 col-lg-12 mx-50">
                                        <div class="pt-25">
                                            <div class="d-flex justify-content-start align-items-end my-25">
                                                @if ($patient->patient_signature)
                                                    <img src="@php echo base64_decode($patient->patient_signature) @endphp"
                                                        class="signature-taken" style="position: relative !important;" />
                                                @elseif ($patient->signature)
                                                    <img src="data:image/jpeg;base64,{{ $patient->signature }}"
                                                        class="signature-taken" />
                                                @else
                                                    <div style="width: 150px;height: 40px;" class="bg-white rounded">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-50">
                                                <a href="/patient_edit/crop_signature?patient_id={{ $patient->id }}"
                                                    style="" class="btn btn-primary btn-sm">
                                                    Edit Signature <i class="fa fa-pencil"></i>
                                                </a>
                                            </div>
                                            <div> <span class="text-white font-weight-bold">
                                                    {{ $patient->firstname . ' ' . $patient->lastname }}
                                                </span>
                                            </div>
                                            <div class="users-view-id text-white">PATIENT ID: {{ $patient->patientcode }}
                                            </div>
                                            <div class="text-white">ADMISSION ID: {{ $admissionPatient ? $admissionPatient->id : "N / A" }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xl-12 mt-sm-2">
                                <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex text-white active" id="account-pill-general"
                                            data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                            <i class="feather icon-globe"></i>
                                            General Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex text-white" id="account-pill-referral"
                                            data-toggle="pill" href="#account-vertical-referral" aria-expanded="false">
                                            <i class="feather icon-file"></i>
                                            Referral Info
                                        </a>
                                    </li>
                                    @if ($admissionPatient)
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-invoice"
                                                data-toggle="pill" href="#account-invoice" aria-expanded="false">
                                                <i class="fa fa-money"></i>
                                                {{ $patient_or ? 'Edit Payment' : 'Generate Payment' }}
                                            </a>
                                        </li>
                                    @endif
                                    @if (session()->get('dept_id') == '1' || session()->get('dept_id') == '17')
                                        @if ($latest_schedule)
                                            <li class="nav-item">
                                                <a class="nav-link d-flex text-white" id="account-pill-password"
                                                    data-toggle="pill" href="#account-vertical-password"
                                                    aria-expanded="false">
                                                    <i class="feather icon-calendar"></i>
                                                    Re Schedule
                                                </a>
                                            </li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link d-flex text-white" id="account-pill-password"
                                                    data-toggle="pill" href="#account-vertical-password"
                                                    aria-expanded="false">
                                                    <i class="feather icon-calendar"></i>
                                                    Add Schedule
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                    @if ($admissionPatient)
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-info"
                                                data-toggle="pill" aria-expanded="false" href="#account-vertical-info">
                                                <i class="feather icon-edit"></i>
                                                Edit Admission
                                            </a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-info"
                                                data-toggle="pill" aria-expanded="false" href="#account-vertical-info">
                                                <i class="feather icon-edit"></i>
                                                Add Admission
                                            </a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link d-flex text-white" id="account-vaccination-record"
                                            data-toggle="pill" aria-expanded="false" href="#account-vaccination-record">
                                            <i class="feather icon-edit"></i>
                                            Yellow Card
                                        </a>
                                    </li>
                                    @if ($admissionPatient)
                                        @if (session()->get('dept_id') == '1' || session()->get('dept_id') == '8' || session()->get('dept_id') == '7')
                                            <li class="nav-item">
                                                <a class="nav-link d-flex text-white" id="account-pill-follow"
                                                    data-toggle="pill" href="#account-vertical-follow"
                                                    aria-expanded="false">
                                                    <i class="fa fa-arrow-circle-left"></i>
                                                    Follow Up Form
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                    @if ($admissionPatient)
                                        @if (session()->get('dept_id') == '1' || session()->get('dept_id') == '8' || session()->get('dept_id') == '17')
                                            <li class="nav-item">
                                                <a class="nav-link d-flex text-white" id="account-pill-social"
                                                    data-toggle="pill" href="#account-vertical-social"
                                                    aria-expanded="false">
                                                    <i class="fa fa-print"></i>
                                                    Print Panel
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-connections"
                                                data-toggle="pill"
                                                onclick="window.open('/admission_print?id={{ $admissionPatient->id }}').print()"
                                                aria-expanded="false">
                                                <i class="fa fa-print"></i>
                                                Print Routing Slip
                                            </a>
                                        </li>
                                    @endif
                                    @if (session()->get('dept_id') == '1')
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-connections"
                                                data-toggle="pill"
                                                onclick="window.open('/referral_pdf?email={{ $patient->email }}').print()"
                                                aria-expanded="false">
                                                <i class="fa fa-print"></i>
                                                Print Referral Slip
                                            </a>
                                        </li>
                                    @endif
                                    @if (session()->get('dept_id') == '1' || session()->get('dept_id') == '17' || session()->get('dept_id') == '8')
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-connections"
                                                data-toggle="pill"
                                                onclick="window.open('/requests_print?id={{ $patientInfo->medical_package }}&patient_id={{ $patient->id }}').print()"
                                                aria-expanded="false">
                                                <i class="fa fa-print"></i>
                                                Print Requests
                                            </a>
                                        </li>
                                    @endif
                                    @if (
                                        ($admissionPatient && session()->get('dept_id') == '1') ||
                                            session()->get('dept_id') == '3' ||
                                            session()->get('dept_id') == '8')
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-connections"
                                                data-toggle="pill"
                                                onclick="window.open('/lab_result?id={{ $admissionPatient ? $admissionPatient->id : 0 }}','wp','width=1000,height=800').print();"
                                                aria-expanded="false">
                                                <i class="fa fa-print"></i>
                                                Print Lab Result
                                            </a>
                                        </li>
                                    @endif

                                    @if ($admissionPatient)
                                        <li class="nav-item">
                                            <a class="nav-link d-flex text-white" id="account-pill-connections"
                                                data-toggle="pill"
                                                onclick="window.open('/medical_record?id={{ $admissionPatient ? $admissionPatient->id : 0 }}&patient_id={{ $patient->id }}','wp','width=1000,height=800').print();"
                                                aria-expanded="false">
                                                <i class="fa fa-print"></i>
                                                Print Medical History
                                            </a>
                                        </li>
                                    @endif

                                    <li class="nav-item">
                                        <a class="nav-link d-flex text-white" id="account-pill-connections"
                                            data-toggle="pill"
                                            onclick="window.open('/data_privacy_print?id={{ $patient->id }}').print()"
                                            aria-expanded="false">
                                            <i class="fa fa-print"></i>
                                            Print Data Privacy Form
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @if ($admissionPatient)
                                <div class="col-lg-5 col-md-4 col-xl-12 my-1">
                                    <h5 class="text-white">MEDICAL STATUS:
                                        <span><b>
                                                @if ($admissionPatient->lab_status == 2)
                                                    <b><u>FIT TO WORK</u></b>
                                                @elseif ($admissionPatient->lab_status == 1)
                                                    <b><u>FINDINGS / RE ASSESSMENT</u></b>
                                                @elseif ($admissionPatient->lab_status == 3)
                                                    <b><u>UNFIT TO WORK</u></b>
                                                @elseif ($admissionPatient->lab_status == 4)
                                                    <b><u>UNFIT TEMPORARILY</u></b>
                                                @endif
                                            </b></span>
                                    </h5>
                                    <div class="my-1">
                                        <button type="button"
                                            class="medical-status-btn btn btn-sm p-75 m-25 text-white btn-outline-primary {{ $admissionPatient->lab_status == 1 ? 'active' : null }}"
                                            data-toggle="modal" data-target="#medicalStatusModal" id="pending_medical_status_btn" data-status="pending">
                                            PENDING
                                        </button>
                                        <button type="button"
                                            class="medical-status-btn btn btn-sm p-75 m-25 text-white btn-outline-primary {{ $admissionPatient->lab_status == 2 ? 'active' : null }}"
                                            data-toggle="modal" data-target="#medicalStatusModal" id="fit_medical_status_btn" data-status="fit">
                                            FIT
                                        </button>
                                        <button type="button"
                                            class="medical-status-btn btn btn-sm p-75 m-25 text-white btn-outline-primary {{ $admissionPatient->lab_status == 3 ? 'active' : null }}"
                                            data-toggle="modal" data-target="#medicalStatusModal" id="unfit_medical_status_btn" data-status="unfit">
                                            UNFIT
                                        </button>
                                        <button type="button"
                                            class="medical-status-btn btn btn-sm p-75 m-25 text-white btn-outline-primary {{ $admissionPatient->lab_status == 4 ? 'active' : null }}"
                                            data-toggle="modal" data-target="#medicalStatusModal" id="unfit_temp_medical_status_btn" data-status="unfit_temp">
                                            UNFIT TEMP
                                        </button>
                                        @if ($admissionPatient->lab_status)
                                            <button class="btn btn-outline-warning medical-status-btn"
                                                id="reset-medical-status-btn">Reset</button>
                                        @endif
                                    </div>
                                    <div class="modal fade text-left" id="medicalStatusModal" role="dialog" aria-labelledby="modalStatusFormLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="modalStatusFormLabel">
                                                        Medical Status
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <button class="btn btn-primary add_new_medical_result_btn">Add New Medical Result</button>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="d-flex justify-content-center align-items-center flex-column" style="gap: 10px;">
                                                                @if(count($patient_medical_results) > 0)
                                                                    @foreach ($patient_medical_results as $medical_result)
                                                                        <div>
                                                                            <button class="btn btn-outline-primary medical_result_btn" id="{{ $medical_result->id }}">
                                                                                {{ date_format(new DateTime($medical_result->generate_at), 'M d, Y') }}
                                                                                <br> 
                                                                                @if ($medical_result->status == 2)
                                                                                    (FIT TO WORK)
                                                                                @elseif ($medical_result->status == 1)
                                                                                    (RE ASSESSMENT)
                                                                                @elseif ($medical_result->status == 3)
                                                                                    (UNFIT TO WORK)
                                                                                @elseif ($medical_result->status == 4)
                                                                                    (UNFIT TEMPORARILY)
                                                                                @endif
                                                                            </button>
                                                                            <button class="btn btn-sm btn-danger btn-block remove_medical_result_btn" data-id="{{ $medical_result->id }}">Remove</button>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <h6>No Medical Result</h6>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <form id="update_lab_result_pending" action="#" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label class="form-label">Lab Status Name</label>
                                                                    <input type="text" name="lab_status_name" class="form-control" id="lab_status_name" readonly>
                                                                </div>
                                                                <input type="hidden" name="lab_status"
                                                                    value="1" id="lab_status">
                                                                <input type="hidden" name="patientId"
                                                                    value="{{ $patient->id }}">
                                                                <input type="hidden" name="medical_result_id" id="medical_result_id">
                                                                <input type="hidden" name="agency_id"
                                                                    value="{{ $patientInfo->agency_id }}">
                                                                <input type="hidden" name="id"
                                                                    value="@php echo $admissionPatient ? $admissionPatient->id : null @endphp">
                                                                <div class="form-group">
                                                                    <label for="">Generate at: 
                                                                        <span style="font-size: 12px;" class="primary">This is the date when you submitted this form. </span>
                                                                    </label>
                                                                    <input type="date" class="form-control" name="generate_at" id="medical_result_generate_at">
                                                                </div>
                                                                <div class="form-group schedule_group">
                                                                    <label>Re Schedule</label>
                                                                    <input class="form-control" type="date"
                                                                        name="schedule" id="schedule" />
                                                                </div>
                                                                {{-- <div class="form-group unfit_date_group">
                                                                    <label>Unfit Date</label>
                                                                    <input class="form-control"
                                                                        value="{{ $patient->unfit_to_work_date }}"
                                                                        type="date" name="unfit_date" id="unfit_date" />
                                                                </div> --}}
                                                                <div class="form-group medical_result_remarks_group">
                                                                    <label for="medical_result_remarks" id="remarks-label">Remarks:</label>
                                                                    <textarea name="remarks" id="medical_result_remarks" cols="30" rows="10" class="form-control">{{ $patient->admission->remarks ?? null }}</textarea>
                                                                </div>
                                                                <div class="form-group medical_result_prescription_group">
                                                                    <label for="medical_result_prescription">Prescription:</label>
                                                                    <textarea name="prescription" id="medical_result_prescription" cols="30" rows="10" class="form-control">{{ $patient->admission->prescription ?? null }}</textarea>
                                                                </div>
                                                                <div class="form-group doctor_prescription_group">
                                                                    <label for="doctor_prescription">Doctor Prescription</label>
                                                                    <select required name="doctor_prescription"
                                                                        id="doctor_prescription" class="select2">
                                                                        @foreach ($doctors as $doctor)
                                                                            <option value="{{ $doctor->id }}">
                                                                                {{ $doctor->firstname . ' ' . $doctor->lastname . ' ' . "($doctor->position)" }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="reset"
                                                                        class="btn btn-outline-secondary btn-lg"
                                                                        data-dismiss="modal" value="close">
                                                                    <button
                                                                        {{ session()->get('dept_id') == 1 ? null : 'disabled' }}
                                                                        type='submit'
                                                                        class='submit-pending btn btn-primary btn-lg'>Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel33" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <label class="modal-title text-text-bold-600" id="myModalLabel33">Laboratory Result</label>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="update_lab_result_reassessment" action="#"
                                                    method="POST">
                                                    @csrf
                                                    @include('Patient.patient_findings', [
                                                        $exam_audio,
                                                        $exam_cardio,
                                                        $exam_ecg,
                                                        $exam_echodoppler,
                                                        $exam_echoplain,
                                                        $exam_ishihara,
                                                        $exam_psycho,
                                                        $exam_physical,
                                                        $exam_psychobpi,
                                                        $exam_stressecho,
                                                        $exam_stresstest,
                                                        $exam_ultrasound,
                                                        $exam_dental,
                                                        $exam_xray,
                                                        $exam_blood_serology,
                                                        $examlab_hiv,
                                                        $examlab_drug,
                                                        $examlab_feca,
                                                        $examlab_hema,
                                                        $examlab_hepa,
                                                        $examlab_urin,
                                                        $examlab_pregnancy,
                                                        $examlab_misc,
                                                    ])
                                                    <div class="modal-body">
                                                        <input type="hidden" name="lab_status" value="1">
                                                        <input type="hidden" name="patientId"
                                                            value="{{ $patient->id }}">
                                                        <input type="hidden" name="agency_id"
                                                            value="{{ $patientInfo->agency_id }}">
                                                        <input type="hidden" name="id"
                                                            value="@php echo $admissionPatient ? $admissionPatient->id : null @endphp">
                                                        <input type="hidden" name="schedule_id"
                                                            value="@php echo $latest_schedule ? $latest_schedule->id : null @endphp">
                                                        <div class="form-group">
                                                            <label for="">Remarks/Recommendations:</label>
                                                            <textarea name="remarks" id="" cols="30" rows="10" class="form-control">@php echo $admissionPatient ? $admissionPatient->remarks : null @endphp</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Next Schedule Date: </label>
                                                            <input type="date" max="2050-12-31" name="schedule"
                                                                class="form-control"
                                                                value="{{ $latest_schedule ? $latest_schedule->date : null }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Doctor Prescription</label>
                                                            <select required name="doctor_prescription" id=""
                                                                class="select2">
                                                                @foreach ($doctors as $doctor)
                                                                    <option value="{{ $doctor->id }}">
                                                                        {{ $doctor->firstname . ' ' . $doctor->lastname . ' ' . "($doctor->position)" }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Prescription</label>
                                                            <textarea name="prescription" id="" cols="30" rows="7" class="form-control">{{ $admissionPatient ? $admissionPatient->prescription : '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="reset" class="btn btn-outline-secondary btn-lg"
                                                            data-dismiss="modal" value="close">
                                                        <button {{ session()->get('dept_id') == 1 ? null : 'disabled' }}
                                                            type='submit'
                                                            class='submit-reassessment btn btn-primary btn-lg'>Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12 col-xl-12 my-1">
                                <div class="container-fluid">
                                    <ul class="nav nav-tabs nav-top-border no-hover-bg" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link primary active" id="home-tab1" data-toggle="tab"
                                                href="#home1" aria-controls="home1" role="tab"
                                                aria-selected="true">Completed Exams</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link primary" id="profile-tab1" data-toggle="tab"
                                                href="#profile1" aria-controls="profile1" role="tab"
                                                aria-selected="false">On Going Exams</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content px-1 pt-1">
                                        <div class="tab-pane active" id="home1" aria-labelledby="home-tab1"
                                            role="tabpanel">
                                            <div class="row">
                                                @if ($completed_exams)
                                                    @foreach ($completed_exams as $key => $patient_exam)
                                                        <div class="col-md-6 col-xl-12 my-50">
                                                            <fieldset>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        name="customCheck" id="customCheck1" checked
                                                                        disabled>
                                                                    <label class="custom-control-label text-white"
                                                                        for="customCheck1">{{ $key }}</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="white">No Exams Found</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tab-pane in" id="profile1" aria-labelledby="profile-tab1"
                                            role="tabpanel">
                                            <div class="row">
                                                @if ($on_going_exams)
                                                    @foreach ($on_going_exams as $key => $patient_exam)
                                                        <div class="col-md-6 col-xl-12 my-50">
                                                            <fieldset>
                                                                <div class="custom-control custom-checkbox ">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        name="customCheck" id="customCheck1" disabled>
                                                                    <label class="custom-control-label text-white"
                                                                        style="word-break: break-all;"
                                                                        for="customCheck1">{{ $key }}</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="white">No Exams Found</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script>
        document.querySelector('#admission-btn').addEventListener('click', () => {
            document.querySelector('#account-pill-info').click();
        })
    </script>

@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="../../../app-assets/js/scripts/signature_pad-master/js/signature_pad.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script type="text/javascript" src="https://www.sigplusweb.com/SigWebTablet.js"></script>
    <script src="../../../app-assets/js/scripts/custom.js"></script>

    <script>
        let agency = document.querySelector('#agency');
        let bahia_ids = [55, 57, 58, 59, 3];
        let vessels_one = ['BLUETERN', 'BOLDTERN', 'BRAVETERN'];
        let vessels_two = ['BALMORAL', 'BOREALIS', 'MS BALMORAL', 'MS BOREALIS'];
        let vessel_three = ['BOLETTE', 'BRAEMAR', 'MS BOLETTE', 'MS BRAEMAR'];
        let all_vessel = [...vessels_one, ...vessels_two, ...vessel_three];

        let hartmann_principals = ['DONNELLY TANKER MANAGEMENT LTD', 'INTERNSHIP NAVIGATION CO. LTD',
            'HARTMANN GAS CARRIER GERMANY GMBH & CO. KG.', 'SEAGIANT SHIPMANAGEMENT LTD.'
        ];

        function selectOccupation(e) {
            if (e.value == 'OTHER' || e == 'OTHER') {
                $('.occupation_other_container').css('display', 'block');
            } else {
                $('.occupation_other_container').css('display', 'none');
            }
        }

        function selectReligion(e) {
            if (e.value == 'OTHERS' || e == 'OTHERS') {
                $('.religion_other_container').css('display', 'block');
            } else {
                $('.religion_other_container').css('display', 'none');
            }
        }

        function showMeds(e) {
            let prescriptionGroup = document.querySelector('.prescription-group');
            if (prescriptionGroup.classList.contains('show-med')) {
                e.innerHTML = 'Show Med';
                prescriptionGroup.classList.remove('show-med');
            } else {
                e.innerHTML = 'Hide Med';
                prescriptionGroup.classList.add('show-med');
            }
        }

        function getPackages(e) {
            let csrf = '{{ csrf_token() }}';
            $.ajax({
                url: '{{ route('agencies.select') }}',
                method: 'post',
                data: {
                    id: e.value,
                    _token: csrf
                },
                success: function(response) {
                    $('#address_of_agency').val(response[1].address);
                    $('#packages option').remove();
                    response[0].forEach(element => {
                        $(`<option value=${element.id}>${element.packagename}</option>`).appendTo(
                            '#packages');
                    });
                    if (bahia_ids.includes(response[1].id)) {
                        getBahiaVessels(response[1], false);
                    } else {
                        $('.bahia-vessel').addClass('remove');
                        $('.natural-vessel').removeClass('remove');
                    }

                    if (response[1].id == 9) {
                        getHartmannPrincipals(false);
                    } else {
                        $('.hartmann-principal').addClass('remove');
                        $('.natural-principal').removeClass('remove');
                    }
                }
            });
        }

        window.addEventListener('load', () => {
            selectOccupation('{{ $patientInfo->occupation }}');
            selectReligion('{{ $patientInfo->religion }}');
            let category = document.querySelector('#admission_category');
            isOtherServices(category);

            if ('{{ Session::get('redirect') }}' != '') {
                let baseString = '{{ Session::get('redirect') }}';
                let directions = baseString.split(";");

                if (directions[0] == 'basic-exam') {
                    document.querySelector('#baseIcon-tab35').click();
                    document.querySelector(`#${directions[3]}`).click();
                } else {
                    document.querySelector('#baseIcon-tab36').click();
                    document.querySelector(`#${directions[3]}`).click();
                }

            }
        });

        function getHartmannPrincipals(isFirst) {
            $('.hartmann-principal').removeClass('remove');
            $('.natural-principal').addClass('remove');
            let selected_principal = $('.hartmann-select-principals').val();
            $('.hartmann-select-principals option').remove();
            console.log(selected_principal);
            if (isFirst) {
                hartmann_principals.forEach(principal => {
                    if (selected_principal == principal) {
                        console.log('same');
                        $(`<option selected value='${principal}'>${principal}</option>`).appendTo(
                            '.hartmann-select-principals');
                    } else {
                        $(`<option value='${principal}'>${principal}</option>`).appendTo(
                            '.hartmann-select-principals');
                    }
                });
            } else {
                hartmann_principals.forEach(principal => {
                    $(`<option value='${principal}'>${principal}</option>`).appendTo(
                        '.hartmann-select-principals');
                });
            }
        }

        function getBahiaVessels(info, isFirst) {
            $('.bahia-vessel').removeClass('remove');
            $('.natural-vessel').addClass('remove');

            let selected_vessel = '{{ $patientInfo->vessel }}';

            $('.bahia-select-vessels option').remove();

            if (info.id == 55) {
                if (isFirst) {
                    vessel_three.forEach(vessel => {
                        if (selected_vessel == vessel) {
                            $(`<option selected value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        } else {
                            $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        }
                    });
                } else {
                    vessel_three.forEach(vessel => {
                        $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                            '.bahia-select-vessels');
                    });
                }
            }

            if (info.id == 57) {
                if (isFirst) {
                    vessels_two.forEach(vessel => {
                        if (selected_vessel == vessel) {
                            $(`<option selected value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        } else {
                            $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        }
                    });
                } else {
                    vessels_two.forEach(vessel => {
                        $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                            '.bahia-select-vessels');
                    });
                }
            }

            if (info.id == 58) {
                if (isFirst) {
                    vessels_one.forEach(vessel => {
                        if (selected_vessel == vessel) {
                            $(`<option selected value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        } else {
                            $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        }
                    });
                } else {
                    vessels_one.forEach(vessel => {
                        $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                            '.bahia-select-vessels');
                    });
                }
            }

            if (info.id == 3) {
                if (isFirst) {
                    all_vessel.forEach(vessel => {
                        if (selected_vessel == vessel) {
                            $(`<option selected value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        } else {
                            $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                                '.bahia-select-vessels');
                        }
                    });
                } else {
                    all_vessel.forEach(vessel => {
                        $(`<option value='${vessel}'>${vessel}</option>`).appendTo(
                            '.bahia-select-vessels');
                    });
                }
            }
        }

        $('.remove-patient-record-btn').click(function (e) {
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure you want to delete it?',
                text: "",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/delete_patient_record',
                        method: 'DELETE',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Deleted!',
                                    'Record has been deleted.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            } else {
                                Swal.fire(
                                    'Error Occured!',
                                    'Internal Server Error.',
                                    'error'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            }
                        }
                    })
                }
            })
        });

        $(".delete-followup").click(function() {
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure you want to delete it?',
                text: "",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/destroy_followup',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status == 201) {
                                Swal.fire(
                                    'Deleted!',
                                    'Record has been deleted.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            } else {
                                Swal.fire(
                                    'Error Occured!',
                                    'Internal Server Error.',
                                    'error'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            }
                        }
                    }).done(function(data) {
                        $(this).html(
                            "<button type='button' class='btn btn-solid btn-success'>FIT TO WORK</button>"
                        )
                    });
                }
            })
        });

        $("#update_lab_result_pending").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $(".submit-pending").html(
                "<button type='submit' class='submit-pending btn btn-primary btn-lg'><i class='fa fa-refresh spinner'></i> Submit</button>"
                );
            $.ajax({
                url: '/update_lab_result',
                method: "POST",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire(
                            'Updated!',
                            'Record has been updated.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    } else {
                        Swal.fire(
                            'Error Occured!',
                            'Internal Server Error.',
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    }
                }
            }).done(function(data) {
                $(this).html(
                    "<input type='submit' class='submit-unfit btn btn-primary btn-lg' value='Submit'>")
            });
        })

        $('.medical-status-btn').click(function(e) {
            $('.add_new_medical_result_btn').click();

            let data_status = e.target.getAttribute('data-status');
            switch (data_status) {
                case 'pending' :
                    $('#lab_status_name').val('Pending');
                    $('#lab_status').val(1);
                    $('.unfit_date_group').hide();
                    $('.schedule_group').show();
                    $('.medical_result_prescription_group').show();
                    $('.doctor_prescription_group').show();
                    break;
                
                case 'fit' :
                    $('#lab_status_name').val('Fit');
                    $('#lab_status').val(2);
                    $('.unfit_date_group').hide();
                    $('.schedule_group').hide();
                    $('.medical_result_prescription_group').show();
                    $('.doctor_prescription_group').show();
                    break;

                case 'unfit' :
                    $('#lab_status_name').val('Unfit');
                    $('#lab_status').val(3);
                    $('.unfit_date_group').show();
                    $('.schedule_group').hide();
                    $('.medical_result_prescription_group').hide();
                    $('.doctor_prescription_group').hide();
                    break;

                case 'unfit_temp' :
                    $('#lab_status_name').val('Unfit Temporarily');
                    $('#lab_status').val(4);
                    $('.unfit_date_group').hide();
                    $('.schedule_group').show();
                    $('.medical_result_prescription_group').show();
                    $('.doctor_prescription_group').show();
                    break;

                default :
                    break;
            }
        });

        $('#reset-medical-status-btn').click(function(e) {
            e.preventDefault();
            $("#reset-medical-status-btn").html(
                "<button type='button' class='btn btn-warning'><i class='fa fa-refresh spinner'></i> Reset</button>"
                );

            $.ajax({
                url: '/update_lab_result',
                method: "POST",
                data: {
                    "_token": '{{ csrf_token() }}',
                    "id": '{{ $patient->admission_id }}',
                    "lab_status": 0
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire(
                            'Updated!',
                            'Record has been updated.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    } else {
                        Swal.fire(
                            'Error Occured!',
                            'Internal Server Error.',
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    }
                }
            }).done(function(data) {
                $(this).html(
                    "<input type='submit' class='submit-fit btn btn-primary btn-lg' value='Submit'>")
            });
        })

        $("#update_lab_result_unfittemp").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $(".submit-unfittemp").html(
                "<button type='submit' class='submit-unfittemp btn btn-primary btn-lg'><i class='fa fa-refresh spinner'></i> Submit</button>"
                );
            $.ajax({
                url: '/update_lab_result',
                method: "POST",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Updated!',
                            'Record has been updated.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    } else {
                        Swal.fire(
                            'Error Occured!',
                            'Internal Server Error.',
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    }
                }
            }).done(function(data) {
                $(this).html(
                    "<input type='submit' class='submit-unfittemp btn btn-primary btn-lg' value='Submit'>"
                    )
            });
        });

        let medical_result_btns = document.querySelectorAll('.medical_result_btn');

        medical_result_btns.forEach(medical_result_btn => {
            medical_result_btn.addEventListener('click', function(e) {
                let id = e.target.getAttribute('id');
                let clickedButton = $(e.target); // Wrap e.target in a jQuery object
                
                // clickedButton.innerHTML = clickedButton;
                if(id) {
                    let spinner = $(" <i class='fa fa-refresh spinner'></i>");
                    clickedButton.append(spinner);
                    clickedButton.prop("disabled", true);
                    $.ajax({
                        url: `/get_patient_medical_result/${id}`,
                        method: "GET",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#medical_result_remarks').val(response.medical_result.remarks);
                                $('#medical_result_prescription').val(response.medical_result.prescription);
                                $('#medical_result_id').val(response.medical_result.id);
                                $('#medical_result_generate_at').val(response.medical_result.generate_at);
                                e.target.setAttribute('id', response.medical_result.id);
                                // Remove the classes from all buttons
                                $('.medical_result_btn').removeClass('btn-primary').addClass('btn-outline-primary');

                                switch (response.medical_result.status) {
                                    case '1' :
                                        $('#lab_status_name').val('Pending');
                                        $('#lab_status').val(1);
                                        $('.unfit_date_group').hide();
                                        $('.schedule_group').show();
                                        $('.medical_result_prescription_group').show();
                                        $('.doctor_prescription_group').show();
                                        break;
                                    
                                    case '2' :
                                        $('#lab_status_name').val('Fit');
                                        $('#lab_status').val(2);
                                        $('.unfit_date_group').hide();
                                        $('.schedule_group').hide();
                                        $('.medical_result_prescription_group').show();
                                        $('.doctor_prescription_group').show();
                                        break;

                                    case '3' :
                                        $('#lab_status_name').val('Unfit');
                                        $('#lab_status').val(3);
                                        $('.unfit_date_group').show();
                                        $('.schedule_group').hide();
                                        $('.medical_result_prescription_group').hide();
                                        $('.doctor_prescription_group').hide();
                                        break;

                                    case '4' :
                                        $('#lab_status_name').val('Unfit Temporarily');
                                        $('#lab_status').val(4);
                                        $('.unfit_date_group').hide();
                                        $('.schedule_group').show();
                                        $('.medical_result_prescription_group').show();
                                        $('.doctor_prescription_group').show();
                                        break;

                                    default :
                                        break;
                                }

                                // Add the class to the clicked button
                                clickedButton.removeClass('btn-outline-primary').addClass('btn-primary');
                            } else {
                                Swal.fire('Not Found!', 'No Medical Result Found', 'error');
                            }
                        }
                    }).done(function(data) {
                        spinner.remove();
                        clickedButton.prop("disabled", false);
                    });
                }
            });
        });

        $('.remove_medical_result_btn').click(function(e) {
            let id = e.target.getAttribute('data-id');
            let csrf = '{{ csrf_token() }}';

            Swal.fire({
                title: 'Are you sure?',
                text: "Remove medical result",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00b5b8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/delete_patient_medical_result`,
                        method: "DELETE",
                        data: {
                            _token: csrf,
                            id: id
                        },
                        success: function(response) {
                            if(response.status == 'success') {
                                Swal.fire(
                                    'Success!', 
                                    response.message, 
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    })
                }
            })
        });


        // Wait for the page to load
        $(document).ready(function() {
            $('.add_new_medical_result_btn').click(function (e) {
                $('#medical_result_remarks').val('');
                $('#medical_result_prescription').val('');
                $('#medical_result_id').val('');
                $('#medical_result_generate_at').val('');
            });
        });

        function getAge(e) {
            var today = new Date();
            var birthDate = new Date(e.value);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            const ageInput = document.querySelector("#age");
            ageInput.value = age;
        }

        function isOtherServices(e) {
            let con = document.querySelector(".other-specify-con");
            if (e.value === 'OTHER SERVICES') {
                con.style.display = 'block';
            } else {
                con.style.display = 'none';
            }
        }

        window.addEventListener('load', () => {
            if (bahia_ids.includes(Number(agency.value))) {
                getBahiaVessels({
                    id: agency.value
                }, true);
            } else {
                $('.bahia-vessel').addClass('remove');
                $('.natural-vessel').removeClass('remove');
            }
            if (agency.value == 9) {
                getHartmannPrincipals(true);
            }

            let lastMenstrualPeriodYes = document.querySelector('#last_menstrual_period1');
            let pregnancyYes = document.querySelector('#pregnancy1');
            if (lastMenstrualPeriodYes.checked) {
                document.querySelector('#last_menstrual_other').style.display = 'block';
            }

            if (pregnancyYes.checked) {
                document.querySelector('#pregnancy_other').style.display = 'block';
            }
        })

        function selectLastMenstrualPeriod(e) {
            if (e.value == 1) {
                document.querySelector('#last_menstrual_other').style.display = 'block';
            } else {
                document.querySelector('#last_menstrual_other').style.display = 'none';
            }
        }

        function selectPregnancy(e) {
            if (e.value == 1) {
                document.querySelector('#pregnancy_other').style.display = 'block';
            } else {
                document.querySelector('#pregnancy_other').style.display = 'none';
            }
        }

        // add Item Table
        let item = document.querySelector('.add-item');
        let itemForms = document.querySelector('.items-form');
        let count3 = 0;
        let count4 = 20;
        item.addEventListener('click', () => {
            const addForm = document.createElement('div');
            addForm.classList.add('item-form-container', 'row', 'border', 'p-1');
            addForm.innerHTML = `<div class="item-name-container col-md-3">
                            <select name="exam[]" class="select2 form-control">
                                <optgroup label="Exams">
                                    <option value="">Select Exam</option>
                                    @foreach ($list_exams as $exam)
                                    <option value="{{ $exam->id }}">
                                        {{ $exam->examname }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="quantity-container col-md-3 text-center">
                            <input class="mx-1" name="charge[${count3++}]" id="charge" type="checkbox" placeholder="Charge" value="package" />
                        </div>
                        <div class="col-md-3 text-center">
                            {{ date('Y-m-d') }}
                        </div>
                        <div class="col-md-3 text-center">
                            <button type="button" onclick="onDeleteItem(this)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </div>`;
            itemForms.appendChild(addForm);
            $('.select2').select2();
        })

        function onDeleteItem(e) {
            return e.parentElement.parentElement.remove();
        }
    </script>
@endpush
