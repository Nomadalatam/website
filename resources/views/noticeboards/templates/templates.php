<script id="noticeboardActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit') ?>" class="btn btn-warning action-btn edit-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-edit"></i>
   </a>
   <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn delete-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-trash"></i>
   </a>






</script>
<script id="isActive" type="text/x-jsrender">
   <label class="custom-switch pl-0">
        <input type="checkbox" name="Is Active" class="custom-switch-input isActive" data-id="{{:id}}" {{:checked}}>
        <span class="custom-switch-indicator"></span>
    </label>

</script>
