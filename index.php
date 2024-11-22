<!DOCTYPE html>
<html lang="ar"dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار</title>
    <script>
        function apiRequest(method, url, data = null, callback) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    callback(JSON.parse(xhr.responseText));
                } else {
                    alert('Request failed');
                }
            };

            xhr.onerror = function () {
                alert('Request error');
            };

            if (data) {
                xhr.send(JSON.stringify(data));
            } else {
                xhr.send();
            }
        }

        function fetchRecords() {
            apiRequest('GET', 'api.php', null, function (data) {
                const list = document.getElementById('recordList');
                list.innerHTML = '';
                data.forEach(record => {
                    const li = document.createElement('li');
                    li.innerHTML = `رقم: ${record.id} | العنوان: ${record.title} | المحتوى: ${record.content} 
                    <button onclick="editRecord(${record.id})" class ='edit'>تعديل</button> 
                    <button onclick="deleteRecord(${record.id}) "class = 'delete'>حذف</button>`;
                    list.appendChild(li);
                });
            });
        }

      function addRecord() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;

    if (!title || !content) {
        alert("Title and Content are required.");
        return;
    }

    const data = { title: title, content: content };

    apiRequest('POST', 'api.php', data, function (response) {
        alert(response.message);
        fetchRecords();
    });
}
        function editRecord(id) {
            const title = prompt('Enter new title:');
            const content = prompt('Enter new content:');

            if (title && content) {
                const data = { title: title, content: content };
                apiRequest('PUT', `api.php?id=${id}`, data, function (response) {
                    alert(response.message);
                    fetchRecords();
                });
            }
        }

        function deleteRecord(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                apiRequest('DELETE', `api.php?id=${id}`, null, function (response) {
                    alert(response.message);
                    fetchRecords(); 
                });
            }
        }

        window.onload = function () {
            fetchRecords();
        };
    </script>
</head>
<body>

<center><h1>استدعاء بيانات والتعديل عليها وحذفها صالح الاختبار</h1></center>

<h2>إضافة جديد</h2>
<div>
<div>العنوان</div>
 <input type="text" id="title" class = 'title' /><br><br>
</div>

<div>
<div>المحتوى</div>
 <textarea id="content" class = 'content'></textarea><br><br>
 
 
<button onclick="addRecord()">إضافة</button>

<h2>القائمه</h2>
<ul id="recordList">
   
</ul>

</body>
</html>
<style>
body{
    padding:20px;
    font-family: "Public Sans Variable", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol" !important;
}
    button{
        font-family: "Public Sans Variable", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol" !important;
         cursor: pointer;
    width: -webkit-fill-available;
    width: -moz-available;
    width: fill-available;
    width: -webkit-fill-available;
    margin: 5px; 
     width: fit-content;
    border-radius: 10px;
    padding: 7px;
    font-weight: 600;
    border:unset;
    }
    
    
    tr .st {
    cursor: pointer;
    width: -webkit-fill-available;
    width: -moz-available;
    width: fill-available;
    width: -webkit-fill-available;
    margin: 5px;
}
.st {
    width: fit-content;
    border-radius: 10px;
    padding: 7px;
    font-weight: 600;
}
.edit {
    color: rgba(205, 146, 0, 1);
    background-color: rgba(205, 146, 0, .2);
}
.delete{
    color: rgba(166, 1, 1, 1);
    background-color: rgba(166, 1, 1, .1);
}
input{
    width: 90%;
    padding: 7px;
    font-size: 18px;
}
textarea{
    width: 90%;
    padding: 7px;
    font-size: 18px;
}
.title{
    border: 1px solid lightgray;
    border-right: 8px solid dodgerblue;
    border-radius: 50px;
    border-left: 8px solid dodgerblue;
    text-align:center;
}
.content{
    padding-right:20px;
    border: 1px solid lightgray;
    border-right: 8px solid #e97f00;
    border-radius: 50px;
    border-left: 8px solid #e97f00;
}
</style>