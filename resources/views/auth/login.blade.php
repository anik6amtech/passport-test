<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .login-header p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .tabs-container {
            background: #f8f9fa;
            padding: 0;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #e9ecef;
        }
        
        .tab {
            flex: 1;
            padding: 15px 10px;
            text-align: center;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .tab.active {
            color: #667eea;
            background: white;
        }
        
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .tab:hover:not(.active) {
            color: #495057;
            background: #e9ecef;
        }
        
        .tab-content {
            padding: 30px;
            background: white;
        }
        
        .tab-pane {
            display: none;
        }
        
        .tab-pane.active {
            display: block;
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        
        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .user-type-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
            }
            
            .tab {
                font-size: 12px;
                padding: 12px 8px;
            }
            
            .login-header {
                padding: 20px;
            }
            
            .login-header h1 {
                font-size: 24px;
            }
            
            .tab-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Please sign in to your account</p>
        </div>
        
        <div class="tabs-container">
            <div class="tabs">
                <button class="tab active" onclick="switchTab('admin')">
                    <svg class="user-type-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                    </svg>
                    Admin
                </button>
                <button class="tab" onclick="switchTab('customer')">
                    <svg class="user-type-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    Customer
                </button>
                <button class="tab" onclick="switchTab('deliveryman')">
                    <svg class="user-type-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-.293-.707L15 4.586A1 1 0 0014.414 4H14v3z"></path>
                    </svg>
                    Delivery
                </button>
                <button class="tab" onclick="switchTab('supplier')">
                    <svg class="user-type-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    Supplier
                </button>
            </div>
        </div>
        
        <div class="tab-content">
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            
            <!-- Admin Login Form -->
            <div id="admin-tab" class="tab-pane active">
                <form method="POST" action="{{ route('login.admin') }}">
                    @csrf
                    <input type="hidden" name="user_type" value="admin">
                    
                    <div class="form-group">
                        <label for="admin-email">Admin Email</label>
                        <input type="email" id="admin-email" name="email" class="form-control" 
                               placeholder="Enter your admin email" required value="{{ old('email') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="admin-password">Password</label>
                        <input type="password" id="admin-password" name="password" class="form-control" 
                               placeholder="Enter your password" required>
                    </div>
                    
                    <button type="submit" class="btn-login">Sign In as Admin</button>
                </form>
            </div>
            
            <!-- Customer Login Form -->
            <div id="customer-tab" class="tab-pane">
                <form method="POST" action="{{ route('login.customer') }}">
                    @csrf
                    <input type="hidden" name="user_type" value="customer">
                    
                    <div class="form-group">
                        <label for="customer-email">Customer Email</label>
                        <input type="email" id="customer-email" name="email" class="form-control" 
                               placeholder="Enter your email" required value="{{ old('email') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="customer-password">Password</label>
                        <input type="password" id="customer-password" name="password" class="form-control" 
                               placeholder="Enter your password" required>
                    </div>
                    
                    <button type="submit" class="btn-login">Sign In as Customer</button>
                </form>
            </div>
            
            <!-- Deliveryman Login Form -->
            <div id="deliveryman-tab" class="tab-pane">
                <form method="POST" action="{{ route('login.deliveryman') }}">
                    @csrf
                    <input type="hidden" name="user_type" value="deliveryman">
                    
                    <div class="form-group">
                        <label for="deliveryman-email">Delivery Person Email</label>
                        <input type="email" id="deliveryman-email" name="email" class="form-control" 
                               placeholder="Enter your email" required value="{{ old('email') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="deliveryman-password">Password</label>
                        <input type="password" id="deliveryman-password" name="password" class="form-control" 
                               placeholder="Enter your password" required>
                    </div>
                    
                    <button type="submit" class="btn-login">Sign In as Delivery Person</button>
                </form>
            </div>
            
            <!-- Supplier Login Form -->
            <div id="supplier-tab" class="tab-pane">
                <form method="POST" action="{{ route('login.supplier') }}">
                    @csrf
                    <input type="hidden" name="user_type" value="supplier">
                    
                    <div class="form-group">
                        <label for="supplier-email">Supplier Email</label>
                        <input type="email" id="supplier-email" name="email" class="form-control" 
                               placeholder="Enter your supplier email" required value="{{ old('email') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="supplier-password">Password</label>
                        <input type="password" id="supplier-password" name="password" class="form-control" 
                               placeholder="Enter your password" required>
                    </div>
                    
                    <button type="submit" class="btn-login">Sign In as Supplier</button>
                </form>
            </div>
            
            <div class="forgot-password">
                <a href="#" onclick="alert('Forgot password functionality will be implemented soon!')">
                    Forgot your password?
                </a>
            </div>
        </div>
    </div>
    
    <script>
        function switchTab(userType) {
            // Remove active class from all tabs and tab panes
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked tab
            event.target.classList.add('active');
            
            // Show corresponding tab pane
            document.getElementById(userType + '-tab').classList.add('active');
        }
        
        // Handle form submission errors - keep the correct tab active
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const userType = urlParams.get('user_type');
            
            if (userType && ['admin', 'customer', 'deliveryman', 'supplier'].includes(userType)) {
                switchTab(userType);
            }
        });
    </script>
</body>
</html>