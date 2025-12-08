<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxe Dashboard Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="login-container flex w-full max-w-5xl h-[600px] bg-white shadow-xl rounded-lg overflow-hidden">
        <section class="login-form-section flex flex-col justify-center items-center p-10 w-full lg:w-1/2 bg-surface">
            <div class="text-center mb-8">
                <h1 class="logo text-4xl font-serif font-bold italic text-primary mb-1">Luxe</h1>
                <p class="subtitle text-sm text-gray-500">Dashboard Login</p>
            </div>
            <form action="#" method="POST" class="w-full max-w-xs space-y-4">

                <div class="form-group">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        placeholder="Enter your Username"
                        class="mt-1 block w-full px-3 py-2 border border-line rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <div class="form-group">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="Enter your Password"
                        class="mt-1 block w-full px-3 py-2 border border-line rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>

                <button
                    type="submit"
                    class="btn-login cursor-pointer w-full py-2 px-4 bg-primary text-white font-semibold rounded-md shadow-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition duration-150 ease-in-out">
                    Login
                </button>
            </form>
            <div class="register-info mt-4 text-xs text-gray-600">
                No Account?
                <a href="#" class="register-link text-link hover:underline font-medium">Register Here</a>
            </div>
            <div class="divider flex items-center w-full max-w-xs my-6">
                <div class="grow border-t border-line"></div>
                <span class="shrink mx-4 text-gray-400 text-xs">OR</span>
                <div class="grow border-t border-line"></div>
            </div>
            <a href="#" class="btn-google flex items-center justify-center w-full max-w-xs py-2 px-4 border border-line rounded-md shadow-sm bg-white text-gray-700 font-medium hover:bg-gray-50 transition duration-150 ease-in-out">
                <img
                    src="logogoogle.webp"
                    alt="Google Logo"
                    class="w-5 h-5 mr-2">
                Login with Google
            </a>
        </section>
        <section class="image-section w-1/2 hidden lg:block"
            style="background-image: url('loginpageimage.JPEG'); background-size: cover; background-position: center;">
        </section>
    </div>
</body>

</html>