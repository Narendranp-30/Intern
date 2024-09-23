import React from 'react';
import ProductForm from './ProductForm';

function AdminDashboard({ products, onAddProduct }) {
    return (
        <div>
            <h1>Admin Dashboard</h1>
            <ProductForm onAddProduct={onAddProduct} />
            <h2>Product List</h2>
            <table border="1" style={{ width: '100%', textAlign: 'left' }}>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    {products.map((product, index) => (
                        <tr key={index}>
                            <td>{product.name}</td>
                            <td>${product.price}</td>
                            <td>{product.description}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

export default AdminDashboard;
