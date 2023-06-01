<!-- Display the form -->
<form method="POST" action="{{ route('tracking') }}" id="trackingForm">
    @csrf
    <label for="tracking_code">Tracking Code:</label>
    <input type="text" id="tracking_code" name="tracking_code" required>
    <button type="submit">Submit</button>
</form>

<!-- Display the tracking results -->
@if(isset($trackingCode))
    <h2>Tracking Results for {{ $trackingCode }}</h2>
    <!-- Display the tracking data retrieved from the API -->
    <!-- Modify this section to fit your specific needs -->
@else
    <p>No tracking code submitted yet.</p>
@endif


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

    let intervalId; // Variable to store the interval ID
    let trackingCode = null; // Variable to store the tracking code

    // Function to set the tracking code in localStorage
    function setTrackingCode(code) {
        localStorage.setItem('trackingCode', code);
    }

    // Function to get the tracking code from localStorage
    function getTrackingCode() {
        return localStorage.getItem('trackingCode');
    }


    // Listen to form submission and set the tracking code
    document.getElementById('trackingForm').addEventListener('submit', function(event) {
        event.preventDefault();
        trackingCode = document.getElementById('tracking_code').value;
        setTrackingCode(trackingCode);
        this.submit();
    });


    function fetchTrackingData() {
        axios.get('/fetch-tracking-data')
            .then(response => {
                if (response.data.success) {
                    const trackingData = response.data.trackingData;
                    // Process and display the tracking data in your UI
                    
                    // Check if a tracking code is stored in localStorage
                    const storedTrackingCode = getTrackingCode();
                    if (storedTrackingCode) {
                        trackingCode = storedTrackingCode;
                        // Use the stored tracking code in your application
                        console.log('Stored tracking code:', trackingCode);
                    }
    
                    if(trackingCode == trackingData.data.number){
                        // Stop the interval if the correct tracking data is received
                        clearInterval(intervalId);
                    }

                    console.log(trackingData);
                } else {
                    // Handle error response
                    console.error(response.data.error);
                }
            })
            .catch(error => {
                // Handle request error
                console.error('Error fetching tracking data:', error);
            });
    }

    // Start the interval and store the interval ID
    intervalId = setInterval(fetchTrackingData, 1000); // Fetch data every 1 second

</script>