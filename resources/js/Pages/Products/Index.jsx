import React from 'react';
import { usePage, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';

export default function ProductIndex() {
  const { products } = usePage().props;

  const addToCart = (id) => {
    router.post(
			'/shop/cart',
			{ product_id: id, quantity: 1 },
			{
				preserveScroll: true,
				onError: () => toast.error('Failed to add to cart.'),
			}
		);
  };

  return (
    <AuthenticatedLayout>
      <h1 className="text-3xl font-bold mb-6 text-gray-800 tracking-tight">Explore Our Products</h1>
      <div className="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        {products.map((p) => (
          <div
            key={p.id}
            className="bg-white rounded-2xl shadow hover:shadow-lg transition-all duration-200 flex flex-col overflow-hidden"
          >
            <div className="p-5 flex flex-col flex-grow">
              <h2 className="text-lg font-semibold text-gray-700 mb-2">{p.name}</h2>
              <p className="text-gray-500 flex-grow">{p.description || 'No description'}</p>
            </div>
            <div className="p-5 flex items-center justify-between border-t">
              <span className="text-indigo-600 font-bold text-lg">${p.price}</span>
              <Button onClick={() => addToCart(p.id)}>Add to Cart</Button>
            </div>
          </div>
        ))}
      </div>
    </AuthenticatedLayout>
  );
}
