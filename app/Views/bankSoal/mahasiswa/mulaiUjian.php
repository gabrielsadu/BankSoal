<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <h1 class="mt-2"><?= $ujian['nama_ujian'] ?></h1><br>
    <h2 class="mt-2">Sisa Waktu: <span id="countdown"></span></h2>
    <form action="/ujian/hasil_ujian/<?= $id ?>" method="post">
        <div class="row">
            <div class="col-9   ">
                <?= csrf_field() ?>
                <table class="table table-borderless">
                    <thead>
                        <th scope="col" style="width: 10%"></th>
                        <th scope="col" style="width: 90%"></th>
                    </thead>
                    <tbody>
                        <?php
                        $answers = array_fill_keys(array_column($soal, 'id'), null);
                        if (isset($_COOKIE['selected_answers'])) {
                            $answers = json_decode($_COOKIE['selected_answers'], true);
                        }

                        foreach ($soal as $k) :
                            // Retrieve the selected answer for the current "soal" if it exists
                            $selectedAnswer = isset($answers[$k['id']]) ? $answers[$k['id']] : null;

                        ?>
                            <tr>
                                <td>
                                    <h1><?= $currentPage; ?></h1>
                                </td>
                                <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;"><?= $k['soal'] ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_a" <?php if ($selectedAnswer === 'jawaban_a') echo 'checked'; ?>>
                                    A. <?= $k['jawaban_a'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_b" <?php if ($selectedAnswer === 'jawaban_b') echo 'checked'; ?>>
                                    B. <?= $k['jawaban_b'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_c" <?php if ($selectedAnswer === 'jawaban_c') echo 'checked'; ?>>
                                    C. <?= $k['jawaban_c'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_d" <?php if ($selectedAnswer === 'jawaban_d') echo 'checked'; ?>>
                                    D. <?= $k['jawaban_d'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <?= $pager->links('soal', 'ujian_pagination'); ?>
                <br>
                <input type="hidden" name="timer" id="timerInput">
                <button type="submit" class="btn btn-primary">Submit Jawaban</button>
            </div>
        </div>
    </form>
</div>

<script>
    // JavaScript code to save the selected answer in the cookie
    document.querySelectorAll('input[name="jawaban[<?= $k['id'] ?>][]"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.checked) {
                var selectedAnswers = <?= json_encode($answers) ?>;
                selectedAnswers[<?= $k['id'] ?>] = this.value;
                document.cookie = "selected_answers=" + JSON.stringify(selectedAnswers) + "; expires=" + (new Date(Date.now() + 86400 * 1000)).toUTCString() + "; path=" + '/';
            }
        });
    });

    // Set the countdown duration in minutes
    var countdownDuration = <?= $ujian['durasi_ujian'] ?>;

    // Get the countdown element
    var countdownElement = document.getElementById('countdown');

    // Start the countdown immediately
    startCountdown();

    function startCountdown() {
        // Check if the countdown end time is already set in a cookie
        var endTime = parseInt(getCookie('countdown_end_time'));

        // Calculate the total countdown time in milliseconds
        var totalTime = countdownDuration * 60 * 1000;

        // If the countdown end time is not set or has expired, calculate and set it
        if (!endTime || Date.now() > endTime) {
            endTime = Date.now() + totalTime;
            setCookie('countdown_end_time', endTime, 60); // Set the cookie to expire in 60 minutes
        }

        // Update the countdown immediately
        updateCountdown();

        // Start the countdown interval
        var countdown = setInterval(updateCountdown, 1000);

        // Function to update the countdown
        function updateCountdown() {
            // Calculate the remaining time
            var remainingTime = endTime - Date.now();
            var minutes = Math.floor(remainingTime / (60 * 1000));
            var seconds = Math.floor((remainingTime % (60 * 1000)) / 1000);

            // Format the time with leading zeros
            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            // Display the countdown timer
            countdownElement.textContent = formattedTime;

            // Check if the countdown has reached 0
            if (remainingTime < 0) {
                // Stop the countdown
                clearInterval(countdown);

                // Auto-submit the form
                document.getElementById('myForm').submit();
            }
        }
    }

    // Function to set a cookie
    function setCookie(name, value, minutes) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (minutes * 60 * 1000));
        document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
    }

    // Function to get the value of a cookie
    function getCookie(name) {
        var cookieName = name + '=';
        var cookieArray = document.cookie.split(';');
        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i].trim();
            if (cookie.indexOf(cookieName) === 0) {
                return cookie.substring(cookieName.length, cookie.length);
            }
        }
        return '';
    }
</script>
<?= $this->endSection(); ?>