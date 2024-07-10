<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm</title>
</head>
<body>
    <form method="GET" action="your_page.php">
        <input type="text" name="search" placeholder="Search for films...">
        <select name="sort">
            <option value="NAME_FILM">Name</option>
            <option value="PREMIERE">Premiere Date</option>
        </select>
        <button type="submit">Search & Sort</button>
    </form>
</body>
</html>