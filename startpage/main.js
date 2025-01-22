$(function() {
    // Make link-wrapper section sortable by drag-and-drop
    $('.container').sortable();

    // Handle completion button click
    $('.completion-button').click(function() {
        // Save new order to an array
        var idList = [];
        $('.link-wrapper').each(function() {
            var id = $(this).attr('id');
            if (id !== undefined) {
                idList.push(Number(id.substring(1)));
            }
        });
        
        // Send AJAX request to save_order.php to update priority column in MySQL
        $.ajax({
            type: 'POST',
            url: 'save_order.php',
            data: { idList: idList } ,
            success: function(response) {
                alert(response);
                location.href="index.php";
            }
        });
    });

    $('.delete-button').click(function() {
        var bookmarkId;
        const elem = document.getElementById('delete-id');
        bookmarkId = Number(elem.textContent);
        console.log(bookmarkId);
        $.ajax({
            type: 'POST',
            url: 'delete_bookmark.php',
            data: { bookmarkId: bookmarkId } ,
            success: function(response) {
                alert(response);
                location.href="index_edit.php";
            }
        });
    });
    
    $('.return-button').click(function() {
        let elem = document.getElementById('delete-popup');
        elem.classList.add("hidden");
        elem = document.getElementById("dark-layer");
        elem.classList.add("hidden");
        $(window).scrollTop(0);
    });
    $('.home-button').click(function() {
        location.href = "index.php";
    });
});

function deleteConfirm(id, name) {
    let elem = document.getElementById('delete-popup');
    elem.classList.remove("hidden");
    elem = document.getElementById("dark-layer");
    elem.classList.remove("hidden");
    elem = document.getElementById("delete-name");
    elem.textContent = name;
    elem = document.getElementById("delete-id");
    elem.textContent = id;
    $(window).scrollTop(0);
};
function editThis(id, name, url) {
    location.href = "add_bookmark.php?id=" + encodeURIComponent(id)
        + "&name=" + encodeURIComponent(name)
        + "&url=" + encodeURIComponent(url);
};
function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
  
function scrollToBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
}