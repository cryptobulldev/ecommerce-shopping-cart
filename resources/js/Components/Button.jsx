import React from 'react';

export default function Button({ children, onClick, className = '', loading = false }) {
  return (
    <button
      disabled={loading}
      onClick={onClick}
      className={`inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-sm hover:bg-indigo-700 active:scale-[0.98] transition-all disabled:opacity-60 ${className}`}
    >
      {loading ? (
        <svg
          className="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
          <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
        </svg>
      ) : null}
      {children}
    </button>
  );
}
