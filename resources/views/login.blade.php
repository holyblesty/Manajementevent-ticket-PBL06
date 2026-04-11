<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="max-w-md w-full bg-white shadow-lg rounded-xl p-8">

    <h1 class="text-3xl font-bold text-purple-600 mb-6 text-center">Login</h1> 
    
    <form class="space-y-4"> 
        
        <input type="text" placeholder="username" 
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"> 
        
        <input type="password" placeholder="password" 
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"> 
        
        <button 
        class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
        Login
        </button> 
    
    </form>

</div>

</body>
</html>