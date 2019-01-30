## Ajax посредством XMLHttpRequest

JQuery:
```php
$.ajax({
  type: 'POST',
  url: '/my/url',
  data: data,
  success: function(resp) {

  },
  error: function() {

  }
});
```

XMLHttpRequest:
```php
var request = new XMLHttpRequest();
request.open('POST', '/my/url', true);

request.onload = function() {
  if (request.status >= 200 && request.status < 400) {
    // Success!
    var resp = request.responseText;
  } else {
    // We reached our target server, but it returned an error

  }
};

request.onerror = function() {
  // There was a connection error of some sort
};

request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send(data);
```

