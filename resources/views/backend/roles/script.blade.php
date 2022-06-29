<script>
    $(document).ready(function(){
      $('#checkbox-all').on('change',function(event){
        event.preventDefault();
        if ($(this).prop('checked')) {
          $('input[type="checkbox"]').prop('checked',true);
        } else {
          $('input[type="checkbox"]').prop('checked',false);
        }
      })
    })

    function clickCheckbox(className,idName) {
      let check = $('#'+idName.id);
      let classNamed = $('.'+className+' input');
      if (check.prop('checked')) {
        classNamed.prop('checked',true);
      } else {
        classNamed.prop('checked',false);
      }
      totalCheckbox()
    }

    function checkByGroup(className, groupId, totalPermission) {
      let groupCheckbox = $('#'+groupId);
      if ($('.'+className+' input:checked').length == totalPermission) {
        groupCheckbox.prop('checked',true);
      }else{
        groupCheckbox.prop('checked',false);
      }
      totalCheckbox()
    }

    function totalCheckbox() {
      let total = '{{$total}}';
      let allCheck = $('input[type="checkbox"]:checked').length;
      if (allCheck >= total) {
        $('#checkbox-all').prop('checked',true);
      }else{
        $('#checkbox-all').prop('checked',false);
      }
    }
  </script>