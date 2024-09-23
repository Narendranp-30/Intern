// App.js
import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Routes, Link } from 'react-router-dom';
import AdminDashboard from './components/AdminDashboard';
import CustomerDashboard from './components/CustomerDashboard';

function App() {
    const [products, setProducts] = useState([]);

    const handleAddProduct = (product) => {
        console.log('Adding product:', product);
        setProducts((prevProducts) => [...prevProducts, product]);
        console.log('Updated products array:', [...products, product]);
    };

    return (
        <Router>
            <nav>
                <ul>
                    <li>
                        <Link to="/admin">Admin Dashboard</Link>
                    </li>
                    <li>
                        <Link to="/customer">Customer Dashboard</Link>
                    </li>
                </ul>
            </nav>
            <Routes>
                <Route 
                    path="/admin" 
                    element={<AdminDashboard onAddProduct={handleAddProduct} />} 
                />
                <Route 
                    path="/customer" 
                    element={<CustomerDashboard products={products} />} 
                />
            </Routes>
        </Router>
    );
}

export default App;
