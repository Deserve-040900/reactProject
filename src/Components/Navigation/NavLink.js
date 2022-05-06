import React, { useContext } from 'react';
import { NavLink } from 'react-router-dom';
import './NavLink.css';

import { AuthContext } from '../../shared/context/auth-context';

const Navbar = (props) => {
  const auth = useContext(AuthContext);
  return (
    <nav>
      <ul className="nav-links">
        <li>
          <NavLink to="/" exact>Home</NavLink>
        </li>
        {/* {auth.isLoggedIn && (
          <li>
            <NavLink to={`/videos/${auth.userId}`}>Master</NavLink>
          </li>
        )} */}
        {auth.isLoggedIn && (
          <li>
            <button onClick={auth.logout}>LOGOUT</button>
          </li>
        )}
      </ul>
    </nav>
  )
};

export default Navbar;