<!DOCTYPE html>
<html>
<head>
    <title>Feedback Widget</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Submit a Ticket</h2>

    <form id="ticketForm" enctype="multipart/form-data">
        <div class="mb-2">
            <label>Name</label>
            <input type="text" name="name" class="w-full border rounded p-2">
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded p-2">
        </div>
        <div class="mb-2">
            <label>Phone</label>
            <input type="text" name="phone" class="w-full border rounded p-2" placeholder="+1234567890">
        </div>
        <div class="mb-2">
            <label>Subject</label>
            <input type="text" name="subject" class="w-full border rounded p-2">
        </div>
        <div class="mb-2">
            <label>Message</label>
            <textarea name="message" class="w-full border rounded p-2"></textarea>
        </div>
        <div class="mb-2">
            <label>File (optional)</label>
            <input type="file" name="file" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </form>

    <div id="successMessage" class="text-green-500 mt-4 hidden"></div>
    <div id="errorMessage" class="text-red-500 mt-4 hidden"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.3/axios.min.js"></script>
<script>
    const form = document.getElementById('ticketForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        document.getElementById('successMessage').classList.add('hidden');
        document.getElementById('errorMessage').classList.add('hidden');

        try {
            const response = await axios.post('{{ route('widget.store') }}', formData, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            document.getElementById('successMessage').textContent = response.data.message;
            document.getElementById('successMessage').classList.remove('hidden');
            form.reset();
        } catch (error) {
            const errors = error.response.data.errors;
            let messages = '';
            for (const field in errors) {
                messages += errors[field].join(' ') + ' ';
            }
            document.getElementById('errorMessage').textContent = messages;
            document.getElementById('errorMessage').classList.remove('hidden');
        }
    });
</script>
</body>
</html>
