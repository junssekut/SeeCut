<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Swiper Stacking Cards</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        body {
            background: #0e0e0e;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .swiper {
            width: 500px;
            height: 500px;
        }

        .swiper-slide {
            overflow: hidden;
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            width: 391px;
            height: 438px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow:
                0 8px 16px rgba(0, 0, 0, 0.2),
                0 16px 32px rgba(0, 0, 0, 0.25);
            /* Realistic layered shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* .swiper-slide-active img {
            box-shadow:
                0 12px 24px rgba(0, 0, 0, 0.3),
                0 24px 48px rgba(0, 0, 0, 0.35);
            transform: scale(1.01);
        } */
    </style>
</head>

<body>

    <!-- Swiper -->


    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            effect: "cards",
            grabCursor: true,
            loop: true, // ✅ Enables infinite looping
            initialSlide: 1, // ✅ Starts at the second slide (index 1)
        });
    </script>
</body>

</html>
