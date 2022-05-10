@php
$form_data = [
    'page_title'=> 'Edit Mobile Bankings',
    'page_subtitle'=> 'Edit Mobile Bankings',
    'form_name' => 'Edit Mobile Bankings',
    'form_id' => 'edit_mobile_bankings',
    'action' => URL::to('/').'/admin/settings/edit-mobile-banking/'.$result->id,
    'form_type' => 'file',
    'fields' => [
        ['type' => 'text', 'class' => '', 'label' => 'Name', 'name' => 'name', 'value' => $result->name],
        ['type' => 'text', 'class' => '', 'label' => 'Mobile No', 'name' => 'mobile_no', 'value' => $result->mobile_no],
        ['type' => 'text', 'class' => '', 'label' => 'Message', 'name' => 'message', 'value' => $result->message],
        ['type' => 'file', 'class' => '', 'label' => 'Image', 'name' => "image", 'value' => '', 'image' => url('public/front/images/mobile_bankings/'.$result['image'])],
        ['type' => 'select', 'options' => $result['country'], 'class' => 'validate_field', 'label' => 'Country', 'name' => 'country_id', 'value' => $result->country_id],
        ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => $result->status]
    ]
];
@endphp
@include("admin.common.form.primary", $form_data)

<script src="{{ asset('public/backend/js/additional-method.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
            $('#edit_mobile_bankings').validate({
                rules: {
                    heading: {
                        required: true
                    },
                    image: {
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
