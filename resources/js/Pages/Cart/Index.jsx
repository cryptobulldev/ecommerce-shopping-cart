import React from 'react';
import { usePage, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Button from '@/Components/Button';

export default function CartIndex() {
  const { cart } = usePage().props;

  const updateQty = (id, qty) => router.patch(`/shop/cart/${id}`, { quantity: qty });
  const removeItem = (id) => router.delete(`/shop/cart/${id}`);
  const checkout = () => router.post('/shop/checkout');

  const total = cart.reduce((sum, item) => sum + item.product.price * item.quantity, 0);

  return (
    <AuthenticatedLayout>
      <h1 className="text-3xl font-bold mb-6 text-gray-800">Your Cart</h1>

      {cart.length === 0 ? (
        <div className="text-gray-500">Your cart is empty.</div>
      ) : (
        <div className="space-y-4">
          {cart.map((item) => (
            <div
              key={item.id}
              className="bg-white rounded-2xl shadow-sm p-5 flex justify-between items-center hover:shadow-md transition"
            >
              <div>
                <h2 className="font-semibold text-gray-700">{item.product.name}</h2>
                <p className="text-sm text-gray-500">${item.product.price}</p>
              </div>
              <div className="flex items-center gap-3">
                <input
                  type="number"
                  value={item.quantity}
                  onChange={(e) => updateQty(item.id, e.target.value)}
                  className="border rounded-md w-16 text-center"
                  min="1"
                />
                <Button
                  onClick={() => removeItem(item.id)}
                  className="bg-red-500 hover:bg-red-600 text-sm px-3"
                >
                  Remove
                </Button>
              </div>
            </div>
          ))}
          <div className="flex justify-between items-center border-t pt-4 mt-6">
            <span className="text-xl font-bold text-gray-700">Total: ${total}</span>
            <Button onClick={checkout} className="px-6 py-2">
              Checkout
            </Button>
          </div>
        </div>
      )}
    </AuthenticatedLayout>
  );
}
