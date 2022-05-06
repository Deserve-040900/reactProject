import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';

import './App.css';
import { useAuth } from './shared/hooks/auth-hook';

import Navigation from './Components/Navigation/MainNavigation';
import { AuthContext } from './shared/context/auth-context';
import Home from './Pages/Home';
import Footer from './Components/Navigation/Footer';

function App() {
  const { token, login, logout, userId } = useAuth();
  let routes;

  if (token) {
    routes = (
      <Routes>
        <Route path="/home" element={<Home />} />
        {/* <Route path="/videos/:userId" exact>
          <UserVideo />
        </Route>
        <Route path="/video/new" exact>
          <NewVideo />
        </Route>
        <Route path="/video/:videoId" exact>
          <UpdateVideo />
        </Route> */}
        <Route path="/" element={<Navigate replace to="/home" />} />
      </Routes>
    );
  } else {
    routes = (
      <Routes>
        <Route path="/" exact>
          <Home />
        </Route>
        {/* <Route path="/auth" exact>
          <Auth />
        </Route>
        <Redirect to="/auth" /> */}
      </Routes>
    );
  }
  return (
    <AuthContext.Provider
      value={{
        isLoggedIn: !!token,
        token: token,
        userId: userId,
        login: login,
        logout: logout,
      }}>
      <Router>
        <Navigation />
        <main>{routes}</main>
        <Footer/>
      </Router>
    </AuthContext.Provider>
  );
}

export default App;

// In react-router-dom v6, "Switch" is replaced by routes "Routes", "Redirect" is replaced by "Navigate".
// If you are upgrading from v5, you will need to use [ npm i -D react-router-dom@latest ]