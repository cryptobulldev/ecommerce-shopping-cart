import { Toaster, toast } from 'react-hot-toast';
import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';

export default function FlashMessage() {
  const { flash } = usePage().props;

  useEffect(() => {
    if (flash?.success) toast.success(flash.success, { duration: 2500 });
    if (flash?.error) toast.error(flash.error, { duration: 2500 });
  }, [flash]);

  return <Toaster position="top-right" reverseOrder={false} />;
}
