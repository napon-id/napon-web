<!-- <script src="https://www.gstatic.com/firebasejs/5.11.1/firebase-app.js"></script> -->
<script src="https://www.gstatic.com/firebasejs/5.9.4/firebase.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    // Initialize Firebase
    var firebaseConfig = {
        apiKey: "AIzaSyD4aGcBRxe8uaNA5tQyyeUklPTBogAI-SY",
        authDomain: "napon-ee0b6.firebaseapp.com",
        databaseURL: "https://napon-ee0b6.firebaseio.com",
        projectId: "napon-ee0b6",
        storageBucket: "napon-ee0b6.appspot.com",
        messagingSenderId: "1088632750476",
        appId: "1:1088632750476:web:64fb9f52a2b10813"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    signin();
    // getFaq();
    // getUserDetail();

    async function signin() {
        console.log('signing in');
        let creds = await firebase.auth().signInWithEmailAndPassword('ipsum123@mailinator.com', 'katakunci123');
        console.log({
            creds
        });
        let token = await creds.user.getIdToken();
        console.log({
            token
        });
        localStorage.setItem('token', token);
        let headers = {
            Authorization: 'Bearer ' + token
        };
        console.log(headers);
        let me = await axios.post('/api/auth?email=ipsum123@mailinator.com', {headers});
        console.log({
            me
        });
    }

    async function getFaq() {
        let headers = {
            Authorization: 'Bearer ' + localStorage.token
        };
        let me = await axios.get('/api/faq', {
            headers
        });
        console.log({
            me
        });
    }

    async function getUserDetail() {
        let headers = {
            Authorization: 'Bearer ' + localStorage.token
        };
        let me = await axios.get('/api/user/orders', {
            headers
        });
        console.log({
            me
        });
    }
</script>