document.write("<link href='css/textEditor.css' rel='stylesheet' />");
document.write("<script src='ckeditor/ckeditor.js'></script>");
document.write("<script src='ckeditor/adapters/jquery.js'></script>");

function funcSelection(ctrl) {
    ctrl.style.height = 50;
}

function CreateEditor() {
    var elems = document.getElementsByClassName("texteditor");
    CKEDITOR.disableAutoInline = true;
   
    for (var idx in elems) {
        var elem = elems[idx];
        var id = elem.id;
        var element2 = document.getElementById(id);
        var parelem = element2.parentElement;
        var chld = document.createElement("input");
        chld.type = "hidden";
        chld.name = id+"_data";
        chld.id = id+"_data";
        parelem.appendChild(chld);
        var ck = CKEDITOR.inline(id);
        ck.on('instanceReady', function (ev) {
            var editor = ev.editor;
            editor.setReadOnly(false);
        });

       // document.gtsel
    }

    return true;

}


$(document).on("mouseout", ".texteditor", function () {
    $(this).removeClass("active").addClass("inactive");
    isEditable = $(this).is('.inactive');
    $(this).prop('contenteditable', !isEditable);
    $(this).removeAttr("title");
    SavetoJson($(this).attr("id"));
});
$(document).on("mouseover", ".texteditor", function () {
    $(this).removeClass("inactive").addClass("active");
    isEditable = $(this).is('.active');
    $(this).prop('contenteditable', isEditable);
});

function SavetoJson(id)
{
    var elem = document.getElementById(id + "_data");
    // editior element id
     var ed_elem=document.getElementById(id);        
     elem.value=ed_elem.innerHTML;
     
     var ed_elem_id=ed_elem.id;
     var path=ed_elem_id.toString().replace(/_/g,";");
     
      $.ajax({
        type: "POST",
        url: document.URL,
        data: {modpath: path, moddata: elem.value},
        cache: false,
        success: function(result){
            
        }
    });
}
