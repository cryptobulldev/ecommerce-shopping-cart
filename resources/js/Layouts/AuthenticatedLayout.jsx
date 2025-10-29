import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import FlashMessage from '@/Components/FlashMessage';

export default function AuthenticatedLayout({ header, children }) {
	const { auth } = usePage().props;
	const user = auth?.user;
	const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

	return (
		<div className="min-h-screen bg-gray-50 text-gray-800 flex flex-col">
			{/* 🔹 NAVBAR */}
			<nav className="bg-white/80 backdrop-blur border-b border-gray-200 sticky top-0 z-50 shadow-sm">
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div className="flex h-16 justify-between items-center">
						{/* Left section */}
						<div className="flex items-center space-x-4">
							<Link href="/" className="flex items-center gap-2">
								<ApplicationLogo className="h-8 w-auto fill-indigo-600" />
								<span className="text-lg font-extrabold text-indigo-600">E-Shop</span>
							</Link>

							<div className="hidden sm:flex sm:space-x-8 sm:ml-10">
								<NavLink href={route('dashboard')} active={route().current('dashboard')}>
									Dashboard
								</NavLink>
								<NavLink href={route('shop.products.index')} active={route().current('shop.products.index')}>
									Products
								</NavLink>
								<NavLink href={route('shop.cart.index')} active={route().current('shop.cart.index')}>
									Cart
								</NavLink>
							</div>
						</div>

						{/* Right section (user dropdown) */}
						<div className="hidden sm:flex sm:items-center space-x-4">
							{user && (
								<Dropdown>
									<Dropdown.Trigger>
										<button
											type="button"
											className="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none transition"
										>
											{user.name}
											<svg
												className="ml-2 h-4 w-4"
												xmlns="http://www.w3.org/2000/svg"
												viewBox="0 0 20 20"
												fill="currentColor"
											>
												<path
													fillRule="evenodd"
													d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
													clipRule="evenodd"
												/>
											</svg>
										</button>
									</Dropdown.Trigger>

									<Dropdown.Content>
										<Dropdown.Link href={route('profile.edit')}>Profile</Dropdown.Link>
										<Dropdown.Link href={route('logout')} method="post" as="button">
											Log Out
										</Dropdown.Link>
									</Dropdown.Content>
								</Dropdown>
							)}
						</div>

						{/* Mobile menu toggle */}
						<div className="sm:hidden">
							<button
								onClick={() => setShowingNavigationDropdown(!showingNavigationDropdown)}
								className="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none transition"
							>
								<svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									{showingNavigationDropdown ? (
										<path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
									) : (
										<path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
									)}
								</svg>
							</button>
						</div>
					</div>
				</div>

				{/* Mobile menu */}
				{showingNavigationDropdown && (
					<div className="sm:hidden bg-white border-t border-gray-200">
						<div className="pt-2 pb-3 space-y-1">
							<ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
								Dashboard
							</ResponsiveNavLink>
							<ResponsiveNavLink href={route('shop.products.index')} active={route().current('shop.products.index')}>
								Products
							</ResponsiveNavLink>
							<ResponsiveNavLink href={route('shop.cart.index')} active={route().current('shop.cart.index')}>
								Cart
							</ResponsiveNavLink>
						</div>

						<div className="border-t border-gray-200 pt-4 pb-1">
							{user && (
								<>
									<div className="px-4 mb-3">
										<div className="text-base font-medium text-gray-800">{user.name}</div>
										<div className="text-sm text-gray-500">{user.email}</div>
									</div>
									<ResponsiveNavLink href={route('profile.edit')}>Profile</ResponsiveNavLink>
									<ResponsiveNavLink method="post" href={route('logout')} as="button">
										Log Out
									</ResponsiveNavLink>
								</>
							)}
						</div>
					</div>
				)}
			</nav>

			{/* 🔹 HEADER (optional page title section) */}
			{header && (
				<header className="bg-white shadow-sm">
					<div className="max-w-7xl mx-auto py-6 px-6 sm:px-8">{header}</div>
				</header>
			)}

			{/* 🔹 MAIN CONTENT */}
			<main className="flex-grow max-w-6xl mx-auto w-full p-6 animate-fadeIn">
				<FlashMessage />
				{children}
			</main>

			{/* 🔹 FOOTER */}
			<footer className="mt-8 border-t py-4 text-center text-sm text-gray-500 bg-white/60 backdrop-blur">
				© {new Date().getFullYear()} E-Shop — Built with ❤️ using Laravel + React
			</footer>
		</div>
	);
}
