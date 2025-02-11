<x-header />

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="section-title text-center">
                    <h2>Register Here</h2>
                    <p>Create your account to get started.</p>
                </div>
                <div class="contact__form">
                    <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="fullname" placeholder="Full Name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="file" name="file" class="form-control-file">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group text-center">
                                    <button type="submit" class="site-btn btn-block">Register</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<x-footer />

<style>
    .contact {
        padding: 100px 0;
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
    }

    .section-title h2 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .section-title p {
        font-size: 16px;
        color: #666;
    }

    .contact__form {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        height: 50px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 16px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-control-file {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .site-btn {
        background: black;
        color: #fff;
        border: none;
        padding: 12px 30px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .site-btn:hover {
        background: #310248;
        transform: translateY(-2px);
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }
</style>