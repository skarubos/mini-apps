document.getElementById('fileToUpload').addEventListener('change', function(e) {
    var file = e.target.files[0];
    var filename = file.name;
    var ext = filename.split('.').pop().toLowerCase();

    if (ext !== 'csv') {
        alert('CSV形式ではありません');
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var contents = e.target.result;
        var lines = contents.split('\n');
        var secondLine = moment(lines[1].substring(0, 16), "YYYY-MM-DD HH:mm");
        var lastLine = moment(lines[lines.length - 2].substring(0, 16), "YYYY-MM-DD HH:mm");

        // MySQLの最新データの日付と比較して場合分け
        var newestText =  document.getElementById('newest-date').textContent;
        var newestDate = moment(newestText, "YYYY-MM-DD HH:mm");
        console.log();
        if (lastLine.isBefore(newestDate)) {
            alert('ファイルに新しいデータが存在しません。\n' + 
                  '\n MySQLデータの最終日: ' + newestDate.format("YYYY-MM-DD HH:mm") + 
                  '\n ファイルデータの最終日: ' + lastLine.format("YYYY-MM-DD HH:mm"));
            return;
        } else if (secondLine.isAfter(newestDate)) {
            let msg = '【注意】データが連続していません！\n' + 
                      '\n MySQLデータの最終日: ' + newestDate.format("YYYY-MM-DD HH:mm") + 
                      '\n ファイルデータの開始日: ' + secondLine.format("YYYY-MM-DD HH:mm") + 
                      '\n\n 本当にアップロードしますか？';
            if(!confirm(msg)) {
                return;
            }
        }

        var confirmMessage = 'ファイル名: ' + filename + '\n' +
                             '開始日: ' + secondLine.format("YYYY-MM-DD HH:mm") + '\n' +
                             '最終日: ' + lastLine.format("YYYY-MM-DD HH:mm") + '\n\n' +
                             'このファイルをアップロードしますか？';

        if (confirm(confirmMessage)) {
            var formData = new FormData();
            formData.append('file', file);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php', true);
            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText === 'completed') {
                    alert('ファイルのアップロードに成功しました');
                    window.location.href = 'index.php';
                } else if (xhr.responseText === 'failed') {
                    alert('ファイルの受け渡しに失敗しました');
                } else {
                    alert('ファイルのアップロードに失敗しました');
                }
            };
            xhr.send(formData);
        } else {
            return;
        }
    };
    reader.readAsText(file);
});
