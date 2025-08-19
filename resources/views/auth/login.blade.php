@extends('layouts.auth-layout')

@section('title', 'Login')

@section('content')
   <div class="flex rounded-2xl overflow-hidden shadow-pastel-lg bg-white border border-pastel-border w-full max-w-5xl">
    <!-- Left Panel -->
    <div class="relative flex-1 hidden md:flex flex-col items-center justify-center p-10 text-center bg-pastel-accent text-pastel-textHeading">
        <div class="relative z-10">
            <img src="{{ asset('FinalIconpng.png') }}" alt="Logo" class="w-24 h-24 mx-auto mb-6">
            <h3 class="text-2xl font-serif font-semibold mb-4">Welcome, Admin</h3>
            <p class="text-base opacity-90">Manage orders, track performance, and optimize your restaurant operations.</p>
        </div>
    </div>

    <!-- Right Panel (Form) -->
    <div class="flex-1 p-6 md:p-10 bg-white">
      @if (session('error'))
          <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
            {{ session('error') }}
          </div>
        @endif
      <h3 class="text-2xl font-serif font-semibold text-pastel-textHeading text-center mb-6">Access Your Portal</h3>
      <form action="{{ route('loginUser') }}" method="POST" class="space-y-5">
        @csrf
        <div class="mb-5">
          <label for="email" class="block font-medium text-pastel-textSecondary text-sm mb-2">Operator ID</label>
          <input 
            type="string" 
            id="uuid" 
            name="uuid"
            class="w-full p-3 rounded-xl border border-pastel-inputBorder bg-pastel-input text-pastel-text shadow-pastel-sm focus:outline-none focus:ring-2 focus:ring-pastel-primary/30 focus:border-pastel-primary transition-all"
            placeholder="Enter your Operator ID" 
            required
          >
        </div>
        
        <div class="mb-5">
          <label for="password" class="block font-medium text-pastel-textSecondary text-sm mb-2">Auth Key</label>
          <input 
            type="password" 
            id="password" 
            name="password"
            class="w-full p-3 rounded-xl border border-pastel-inputBorder bg-pastel-input text-pastel-text shadow-pastel-sm focus:outline-none focus:ring-2 focus:ring-pastel-primary/30 focus:border-pastel-primary transition-all"
            placeholder="Enter your Auth Key" 
            required
          >
        </div>
        
        <button 
          type="submit" 
          class="w-full py-3 px-4 bg-pastel-primary text-white font-medium rounded-xl shadow-pastel-sm hover:bg-pastel-primaryHover hover:shadow-pastel-md transform hover:-translate-y-0.5 transition-all"
        >
          Login
        </button>
        
        <p class="text-center mt-6 text-sm text-pastel-textSecondary">
          Need clearance? <a href="#" class="text-pastel-primary font-medium hover:underline">Request Access</a>
        </p>
      </form>
    </div>
  </div>
@endsection