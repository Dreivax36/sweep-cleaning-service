<!DOCTYPE html>
<html>
<body>
  <p>
    Click the button to wait 3 seconds, then alert "Hello".
  </p>

  <button onclick="myFunction()">Try it</button>

  <script>
    function myFunction() {
      setTimeout(function(){ alert("Hello"); }, 3000);
    }
  </script>
</body>
</html>
