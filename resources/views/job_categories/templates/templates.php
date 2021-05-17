<script id="jobCategoryActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit') ?>" class="btn btn-warning action-btn edit-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-edit"></i>
   </a>
   <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn delete-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-trash"></i>
   </a>  

</script>


<script id="isFeatured" type="text/x-jsrender">
   <label class="custom-switch pl-0">
        <input type="checkbox" name="show_to_staff" class="custom-switch-input isFeatured" data-id="{{:id}}" {{:checked}}>
        <span class="custom-switch-indicator"></span>
    </label>
</script>
