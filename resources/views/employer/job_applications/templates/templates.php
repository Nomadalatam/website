<script id="jobApplicationActionTemplate" type="text/x-jsrender">
 <div class="dropdown d-inline mr-2">
      <button class="btn btn-primary dropdown-toggle" type="button" id="actionDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
      <div class="dropdown-menu">
        {{if !isCompleted}}
            {{if !isShortlisted}}
            <a class="dropdown-item short-list" href="#" data-id="{{:id}}"><?php echo __('messages.common.shortlist') ?></a>
            {{/if}}
            <a class="dropdown-item action-completed" href="#" data-id="{{:id}}"><?php echo __('messages.common.selected') ?></a>
            <a class="dropdown-item action-decline" href="#" data-id="{{:id}}"><?php echo __('messages.common.rejected') ?></a>
        {{/if}}
        <a class="dropdown-item action-delete" href="#" data-id="{{:id}}"><?php echo __('messages.common.delete') ?></a>
    </div>
 </div>

</script>
