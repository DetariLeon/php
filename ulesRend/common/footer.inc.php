<style>
    body {
        background-color: rgb(236, 232, 227);
    }

    section {
        padding: 60px;
        text-align: center;
    }

    h1 {
        padding: 20px auto;
        text-align: center;
    }

    h2 {
        padding: 20px auto;
        text-align: center;
        margin-bottom: 40px;
    }

    section form input {
        padding: 10px 20px;
        border-radius: 10px;
        border: 1px solid black;
        display: block;
        margin-bottom: 10px;
    }

    .pfp {
        height: 100%;
        width: 100%;
        max-width: 200px;
        max-height: 200px;
    }
</style>
</body>

</html>

<?php

if (isset($conn)) {
    $conn->close();
}

?>