@php
$form_data = [
    'page_title'=> 'Add Mobile Bankings',
    'page_subtitle'=> 'Add Mobile Bankings',
    'form_name' => 'Add Mobile Bankings',
    'form_id'=>'add_mobile_bankings',
    'action' => URL::to('/').'/admin/settings/add-mobile-banking',
    'form_type' => 'file',
    'fields' => [
        ['type' => 'text', 'class' => '', 'label' => 'Name', 'name' => 'name', 'value' => ''],
        ['type' => 'text', 'class' => '', 'label' => 'Mobile No', 'name' => 'mobile_no', 'value' => ''],
        ['type' => 'text', 'class' => '', 'label' => 'Message', 'name' => 'message', 'value' => ''],
        ['type' => 'file', 'class' => '', 'label' => 'Image', 'name' => "image", 'value' => '','hint'=>'(Width:1920px and Height:860px)'],
        ['type' => 'select', 'options' => $country, 'class' => 'validate_field', 'label' => 'Country', 'name' => 'country_id', 'value' => ''],
        ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => ''],
    ]
];
@endphp
@include("admin.common.form.primary", $form_data)

<script src="{{ asset('public/backend/js/additional-method.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
            $('#add_banners').validate({
                rules: {
                    heading: {
                        required: true
                    },
                    image: {
                        required: true,
                        //extension: "jpg|png|jpeg"
                        accept: "image/jpg,image/jpeg,image/png"
                    }
                },
                messages: {
                    image: {
                        accept: 'The file must be an image (jpg, jpeg or png)'
                    }
                }
            });
        });
</script>
