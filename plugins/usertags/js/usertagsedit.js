(function ($) {
    $(function () {
        console.log("loaded");
        var $usersAvail = $('#usersAvailable'),
       	    $usersAssigned = $('#usersAssigned');

   	    // let the gallery items be draggable
        $( "li", $usersAvail ).draggable({
            revert: "invalid", // when not dropped, the item will revert back to its initial position
            containment: "#userTags",
            helper: "clone",
            cursor: "move"
        });

        $( "li", $usersAssigned ).draggable({
            revert: "invalid", // when not dropped, the item will revert back to its initial position
            containment: "#userTags",
            helper: "clone",
            cursor: "move"
        });

          // let the trash be droppable, accepting the gallery items
        $usersAssigned.droppable({
            accept: "#usersAvailable li",
            activeClass: "user-tags-highlight",
            drop: function( event, ui ) {
                deleteUser( ui.draggable );
            }
        });

         // let the gallery be droppable as well, accepting items from the trash
        $usersAvail.droppable({
            accept: "#usersAssigned li",
            activeClass: "custom-state-active",
            drop: function( event, ui ) {
                recycleUser( ui.draggable );
            }
        });

        var user_input = '<input type="hidden" name="user_assigned[]" class="user-tags-input"/>';
        function deleteUser($item){
        	$item.fadeOut(function() {
                $item.appendTo($usersAssigned).fadeIn(function(){

                })
            }).append($(user_input).val($item.data('userid')));
            // }).append($(user_input).val('{"id":"'+$item.data('userid')+'","username":"'+ $item.data('username')+'"}'))

        }

        function recycleUser($item){
            $item.fadeOut(function() {
        		$item.detach()
                    .appendTo($usersAvail)
                    .fadeIn(function(){});
        	}).find('.user-tags-input').remove();
        }

    });
}(jQuery));