import Routes from "./Routes";
import AuthProvider from "./providers/AuthProvider";

function App() {
    return (
        <AuthProvider>
            <Routes />
        </AuthProvider>
    );
}

export default App;
