// Script for hide answer's form in show.blade.php
$(document).ready(function() {
  $(document).on('click', '.answer_btn', function() {
      var containerId = 'container_answer_' + $(this).attr('id').split('_')[2];
      var formContainer = $("#" + containerId);
      formContainer.toggle();
  });
});