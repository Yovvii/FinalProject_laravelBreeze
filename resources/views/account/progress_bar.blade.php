<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
        }
        .progress-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1250px;
            padding: 2rem 10rem;
            margin: 2rem auto;
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }
        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            width : calc(100% - 48px);
            height: 4px;
            background-color: rgb(37, 99, 235);
            z-index: 1;
            transform: translateY(-50%);
            display: none;
        }
        .step-circle {
            position: relative;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e2e8f0;
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            cursor: pointer;
        }
        .step-circle.completed {
            background-color: rgb(37, 99, 235);
        }
        .step-circle.active {
            border: 4px solid rgb(37, 99, 235);
            background-color: white;
            color: rgb(37, 99, 235);
        }
        .step-label {
            position: absolute;
            top: 110%;
            white-space: nowrap;
            font-size: 0.875rem;
            color: #64748b;
            text-align: center;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
        }
        .step-circle .check-icon {
            display: none;
        }
        .step-circle.completed .check-icon {
            display: block;
            width: 24px;
            height: 24px;
        }
        .step-circle.completed .step-number {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">

<div class="max-w-7xl mx-auto sm:px-4 lg:px-6 pt-5">
    <div class="bg-white p-4 rounded-lg">
        <div class="p-3 bg-blue-100 rounded-lg ">
            Selamat datang <span class="font-semibold">Yovi</span>
            <p class="mt-2 text-sm/6"><span class="font-bold">Perhatian! Hindari Penipuan!</span>
                Harap berhati-hati terhadap pihak yang meminta uang dengan mengatasnamakan panitia. Pastikan Anda hanya mengakses informasi dari situs web resmi ini.
                <span class="font-bold">Pelaksanaan SPMB 2026/2027 GRATIS & bebas dari segala macam bentuk percaloan !!!</span>
            </p>
            <hr class="my-4 border-gray-400"> <p class="text-xs text-gray-500">
                Panitia SPMB Kabupaten Purbalingga
            </p>
        </div>
    </div>
</div>

    <!-- Progress Bar Section -->
    <div class="progress-container">
        <div id="progressBar" class="progress-line bg-blue-600"></div>
        
        <div id="step1" class="step-circle step-1">
            <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
            </svg>
            <span class="step-label">Data Siswa</span>
        </div>

        <div id="step2" class="step-circle step-2">
            <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
            </svg>
            <span class="step-label">Rapor</span>
        </div>

        <div id="step3" class="step-circle step-3">
            <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
            </svg>
            <span class="step-label">Surat Pernyataan</span>
        </div>

        <div id="step4" class="step-circle step-4">
            <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
            </svg>
            <span class="step-label">Surat Lulus & Ijazah</span>
        </div>
    </div>
    
    <div class="py-5 w-full">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form method="POST" action="/submit-form" enctype="multipart/form-data">
                    <input type="hidden" name="current_step" id="current_step" value="1">                    
                    <div class="mt-4 flex justify-end gap-x-3">
                        <button type="button" onclick="beforeStep()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Kembali
                        </button>
                        <button type="button" onclick="nextStep()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Lanjut
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        updateProgressBar(1); // Set initial state to step 1
    });

    function updateProgressBar(step) {
        const steps = document.querySelectorAll('.step-circle');
        const progressBar = document.getElementById('progressBar');
        const numSteps = steps.length;
        
        // Update progress bar line
        // const progressPercentage = ((step - 1) / (numSteps - 1)) * 100;
        // progressBar.style.width = `${progressPercentage}%`;
        
        // Update step circles
        steps.forEach((stepCircle, index) => {
            const stepNumber = index + 1;
            if (stepNumber < step) {
                stepCircle.classList.add('completed');
                stepCircle.classList.remove('active');
            } else if (stepNumber === step) {
                stepCircle.classList.add('active');
                stepCircle.classList.remove('completed');
            } else {
                stepCircle.classList.remove('completed', 'active');
            }
        });

        // Show/hide forms
        const formSteps = document.querySelectorAll('.form-step');
        formSteps.forEach(form => form.classList.add('hidden'));
        document.getElementById(`form-step-${step}`).classList.remove('hidden');
    }

    function nextStep() {
        const currentStepInput = document.getElementById('current_step');
        let currentStep = parseInt(currentStepInput.value);
        if (currentStep <= 4) {
            currentStep++;
            currentStepInput.value = currentStep;
            updateProgressBar(currentStep);
        }
    }
    
    function beforeStep() {
        const currentStepInput = document.getElementById('current_step');
        let currentStep = parseInt(currentStepInput.value);
        if (currentStep > 1) {
            currentStep--;
            currentStepInput.value = currentStep;
            updateProgressBar(currentStep);
        }
    }
</script>

</body>
</html>
