import React, { useState } from 'react';

function ProductForm({ onAddProduct }) {
    const [name, setName] = useState('');
    const [price, setPrice] = useState('');
    const [description, setDescription] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        const newProduct = { name, price, description };
        onAddProduct(newProduct);
        setName('');
        setPrice('');
        setDescription('');
    };

    return (
        <form onSubmit={handleSubmit}>
            <div>
                <label>Product Name</label>
                <input 
                    type="text" 
                    value={name} 
                    onChange={(e) => setName(e.target.value)} 
                    required 
                />
            </div>
            <div>
                <label>Price</label>
                <input 
                    type="text" 
                    value={price} 
                    onChange={(e) => setPrice(e.target.value)} 
                    required 
                />
            </div>
            <div>
                <label>Description</label>
                <input 
                    type="text" 
                    value={description} 
                    onChange={(e) => setDescription(e.target.value)} 
                    required 
                />
            </div>
            <button type="submit">Add Product</button>
        </form>
    );
}

export default ProductForm;
