<script src="https://www.gstatic.com/firebasejs/5.9.4/firebase.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyAqFVyrPZuPN19_JTxGmgEA0uBBsoZpXqQ",
        authDomain: "napon-ce32c.firebaseapp.com",
        databaseURL: "https://napon-ce32c.firebaseio.com",
        projectId: "napon-ce32c",
        storageBucket: "napon-ce32c.appspot.com",
        messagingSenderId: "429643042573"
    };
    firebase.initializeApp(config);
    // signin();
    getFaq();

    async function signin() {
        console.log('signing in');
        let creds = await firebase.auth().signInWithEmailAndPassword('lorem@mailinator.com', 'katakunci');
        console.log({ creds });
        let token = await creds.user.getIdToken();
        console.log({ token });
        localStorage.setItem('token', token);
        let headers = { Authorization: 'Bearer ' + token };
        let me = await axios.get('http://localhost:8000/api/me', { headers });
        console.log({ me });
    }

    async function getFaq() {
        let headers = { Authorization: 'Bearer ' + localStorage.token };
        let me = await axios.get('http://localhost:8000/api/faq', { headers });
        console.log({me});
    }
    </script>