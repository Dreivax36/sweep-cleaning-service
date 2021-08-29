@extends('head_extention_welcome') 

@section('content')
    <title>
        FAQs Page
    </title>
<body>
    <header> <!-- Navbar --> 
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li>
                    <a class="nav_con" href="sweep_welcome">
                        Home
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="#">
                        Services
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="sweep_contact_us">
                        Contact Us
                    </a>
                </li>
                <li>
                    <a class="nav_con active" href="sweep_faqs">
                        FAQs
                    </a>
                </li>
                <li>
                    <a class="nav_con" href="sweep_about_us">
                        About Us
                    </a>
                </li>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header> <!-- End of Navbar --> 
    
    <div class="faqs_con">
        <h3 class="faqs_title">
            Frequently Asked Questions
        </h3>
        <table class="table table-hover faqs_table">
            <tbody>
                <tr>
                    <td class="faqs_row"> 
                        Q: <b>How to book a cleaning service?</b>
                        <br>
                        A:
                    </td>
                </tr>
                <tr>
                    <td class="faqs_row">
                        Q: <b>Can I cancel a booked service?</b>
                        <br>
                        A:
                    </td>
                </tr>
                <tr>
                    <td class="faqs_row">
                        Q: <b>How long a cleaning service will last?</b>
                        <br>
                        A:
                    </td>
                </tr>
                <tr>
                    <td class="faqs_row">
                        Q: <b>Is SWEEP safe?</b>
                        <br>
                        A:
                    </td>
                </tr>
                <tr>
                    <td class="faqs_row">
                        Q: <b>How to pay a booked service?</b>
                        <br>
                        A:
                    </td>
                </tr>
                <tr>
                    <td class="faqs_row">
                        Q: <b>What are the cleaning services offered?</b>
                        <br>
                        A:
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="fixed_footer"> <!-- Footer --> 
        <div class="d-flex">
            <div class="footer_info_con">
                <h5>
                    Do You Want Squeacky-Clean Floors?
                </h5>
                <p>
                    Call <u class="contact_no">09897656345</u> today to get a free estimate on our services.
                </p>
            </div>
            <div class="footer_info_con">
                <p>
                    When you need regular cleaning services for your house, you can rely on the professionals at SWEEP to provide them for you. We're available for recurring cleaning services and short-notice deep cleans when you're preparing for important guests.
                </p>
            </div>
            <div class="form-group footer_sign_con">
            <input type="text" placeholder="Email" class="form-control signup_field">
            <button type="button" class="btn btn-block btn-primary footer_signup_btn"> 
                Sign Up Now
            </button>
        </div>
        </div>
        <div class="footer_content">
            Copyright &copy; 2021 Ateneo de Naga University
        </div>        
    </div> <!-- End of Footer -->
    
</body>
@endsection