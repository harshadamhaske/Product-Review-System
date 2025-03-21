<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Product Review System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous"/>

    <style>
        body {
            background: #f5f5dc;
            font-family: 'Poppins', sans-serif;
            color: #333;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 100%;
            height: 100vh;
            padding: 20px;
            border: 5px solid black;
            border-radius: 10px;
            background: white;
            overflow: auto;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            background: #333;
            color: #f5f5dc;
        }

        .btn-primary {
            background: black;
            border: 2px solid #f5f5dc;
            font-size: 18px;
            padding: 12px 25px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: #f5f5dc;
            color: black;
            border: 2px solid black;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .star-light {
            color: white;
        }

        .progress-bar {
            border-radius: 10px;
        }

        .modal-content {
            border-radius: 15px;
            background: #333;
            color: #f5f5dc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4 text-center">
            <h2 class="text-warning">Product Review System</h2>
            <div class="row mt-4 align-items-center">
                <div class="col-md-3 text-center">
                    <img src="https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcRZyaYef59WxLHvovURkWkdc6OeeDf3qR0mTQTjx_OnIgk4-uKzJPfd3PDyJD8U_DE0sqkS4K5VQhzIdWck7oq84FME6sdO1xNfCcGvSMlUSZYEkVdVI1sFdg" class="img-fluid rounded" alt="Product">
                    <button type="button" class="btn btn-primary mt-3" id="add_review">Rate & Review</button>
                </div>
                <div class="col-md-4 text-center">
                    <h1 class="text-warning">
                        <b><span id="average_rating">0.0</span> / 5</b>
                    </h1>
                    <div>
                        <i class="fas fa-star star-light mr-1 main_star" data-rating="1"></i>
                        <i class="fas fa-star star-light mr-1 main_star" data-rating="2"></i>
                        <i class="fas fa-star star-light mr-1 main_star" data-rating="3"></i>
                        <i class="fas fa-star star-light mr-1 main_star" data-rating="4"></i>
                        <i class="fas fa-star star-light mr-1 main_star" data-rating="5"></i>
                    </div>
                    <h4><span id="total_review">0</span> Reviews</h4>
                </div>

                <!-- Review Section -->
                <div id="review_section" class="col-md-5">
                    <p class="text-muted">No reviews yet.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-star star-light submit_star mr-1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" data-rating="5"></i>
                    </div>
                    <input type="text" class="form-control mb-2" placeholder="Your Name" id="user_name">
                    <textarea class="form-control" placeholder="Your Review" id="user_review"></textarea>
                    <button class="btn btn-primary mt-3" id="save_review">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            let selectedRating = 0;
            let reviews = [];
            let totalRating = 0;
            let reviewCount = 0;
            
            $('#add_review').click(function(){
                $('#review_modal').modal('show');
            });

            $('.submit_star').click(function(){
                selectedRating = $(this).data('rating');
                $('.submit_star').removeClass('text-warning').addClass('star-light');
                for(let i = 1; i <= selectedRating; i++) {
                    $('[data-rating="' + i + '"]').removeClass('star-light').addClass('text-warning');
                }
            });

            $('#save_review').click(function(){
                let userName = $('#user_name').val().trim();
                let userReview = $('#user_review').val().trim();
                if(userName === '' || userReview === '' || selectedRating === 0){
                    alert('Please fill in all fields and select a rating.');
                    return;
                }

                totalRating += selectedRating;
                reviewCount++;
                let avgRating = (totalRating / reviewCount).toFixed(1);
                $('#average_rating').text(avgRating);
                $('#total_review').text(reviewCount);

                let reviewHtml = `
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5>${userName}</h5>
                            <p>${userReview}</p>
                            <div>`;
                for(let i = 1; i <= 5; i++) {
                    reviewHtml += `<i class="fas fa-star ${i <= selectedRating ? 'text-warning' : 'star-light'}"></i>`;
                }
                reviewHtml += `</div></div></div>`;

                reviews.push(reviewHtml);
                
                $('#review_section').html(reviews.join(''));

                $('#user_name').val('');
                $('#user_review').val('');
                selectedRating = 0;
                $('.submit_star').removeClass('text-warning').addClass('star-light');
                $('#review_modal').modal('hide');
            });
        });
    </script>
</body>
</html>
