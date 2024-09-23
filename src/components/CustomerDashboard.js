import React from 'react';

function CustomerDashboard({ products }) {
    return (
        <div>
            <h1>Customer Dashboard</h1>
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

export default CustomerDashboard;
