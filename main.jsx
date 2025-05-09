import React, { useState } from 'react';
import { Bell, User, LogOut, Home, Award, TrendingUp, ExternalLink, ArrowRight, CheckCircle, CheckCircle2, Gift } from 'lucide-react';

const AffiliateDashboard = () => {
  const [currentPage, setCurrentPage] = useState('dashboard');
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  
  // Mock data
  const userData = {
    name: "Alex Johnson",
    profilePic: "/api/placeholder/150/150",
    earnings: "RM1,245.80",
    salesCount: 128,
    clickCount: 3841,
    conversionRate: "3.3%"
  };
  
  const missionData = [
    { id: 1, title: "Kongsi 5 pautan affiliate", progress: 3, target: 5, reward: "50 mata" },
    { id: 2, title: "Lengkapkan profil", progress: 1, target: 1, completed: true, reward: "100 mata" },
    { id: 3, title: "Hasilkan jualan pertama", progress: 1, target: 1, completed: true, reward: "200 mata" },
    { id: 4, title: "Capai kadar penukaran 3%", progress: 3.3, target: 3, completed: true, reward: "300 mata" },
    { id: 5, title: "Capai jualan RM1000", progress: 1245.8, target: 1000, completed: true, reward: "500 mata" }
  ];
  
  const rewardsData = [
    { id: 1, title: "Bonus Tunai", amount: "RM25", available: true, icon: "💰" },
    { id: 2, title: "Kad Hadiah Amazon", amount: "RM50", available: true, icon: "🎁" },
    { id: 3, title: "Akses Premium", amount: "1 Bulan", available: false, icon: "⭐" },
    { id: 4, title: "Sorotan Istimewa", amount: "Laman Utama", available: false, icon: "🔍" }
  ];
  
  const brandsData = [
    { id: 1, name: "TechGadget", commission: "10%", logo: "/api/placeholder/60/60" },
    { id: 2, name: "FashionHub", commission: "15%", logo: "/api/placeholder/60/60" },
    { id: 3, name: "HealthPlus", commission: "12%", logo: "/api/placeholder/60/60" },
    { id: 4, name: "HomeDecor", commission: "8%", logo: "/api/placeholder/60/60" },
    { id: 5, name: "BookWorld", commission: "20%", logo: "/api/placeholder/60/60" }
  ];
  
  // Login component
  const LoginPage = () => {
    const [phoneNumber, setPhoneNumber] = useState('');
    const [otp, setOtp] = useState(['', '', '', '', '', '']);
    const [step, setStep] = useState(1); // 1: phone input, 2: OTP verification
    const otpInputRefs = Array(6).fill(0).map(() => React.createRef());
    
    const handlePhoneChange = (e) => {
      const input = e.target.value.replace(/\D/g, '');
      setPhoneNumber(input);
    };
    
    const handleRequestOTP = () => {
      if (phoneNumber.length >= 10) {
        setStep(2);
        // Focus the first OTP input
        setTimeout(() => {
          if (otpInputRefs[0].current) {
            otpInputRefs[0].current.focus();
          }
        }, 100);
      }
    };
    
    const handleOtpChange = (index, e) => {
      const value = e.target.value;
      if (value.length > 1) return;
      
      const newOtp = [...otp];
      newOtp[index] = value;
      setOtp(newOtp);
      
      // Auto focus next input
      if (value && index < 5) {
        otpInputRefs[index + 1].current.focus();
      }
    };
    
    const handleKeyDown = (index, e) => {
      // Handle backspace
      if (e.key === 'Backspace' && !otp[index] && index > 0) {
        otpInputRefs[index - 1].current.focus();
      }
    };
    
    const handleVerifyOTP = () => {
      if (otp.join('').length === 6) {
        setIsLoggedIn(true);
      }
    };
    
    return (
      <div className="flex flex-col items-center justify-center min-h-screen p-6 bg-gradient-to-b from-indigo-500 to-purple-600">
        <div className="w-full max-w-md bg-white rounded-lg shadow-xl p-8">
          <div className="text-center mb-8">
            <h1 className="text-2xl font-bold text-gray-800">Dashboard Affiliate</h1>
            {step === 1 ? (
              <p className="text-gray-600 mt-2">Log masuk dengan nombor telefon anda</p>
            ) : (
              <p className="text-gray-600 mt-2">Masukkan kod 6-digit yang dihantar ke nombor telefon anda</p>
            )}
          </div>
          
          {step === 1 ? (
            <div className="space-y-6">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label>
                <div className="flex">
                  <div className="flex items-center px-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l-lg">
                    <span className="text-gray-500">+60</span>
                  </div>
                  <input 
                    type="tel" 
                    value={phoneNumber}
                    onChange={handlePhoneChange}
                    className="w-full px-4 py-3 rounded-r-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="1xxxxx xxxx"
                    maxLength={11}
                  />
                </div>
              </div>
              
              <button
                type="button"
                onClick={handleRequestOTP}
                disabled={phoneNumber.length < 10}
                className={`w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white ${
                  phoneNumber.length >= 10 
                    ? 'bg-indigo-600 hover:bg-indigo-700' 
                    : 'bg-indigo-300 cursor-not-allowed'
                } focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500`}
              >
                Hantar Kod Pengesahan
              </button>
              
              <div className="mt-6 text-center">
                <p className="text-sm text-gray-600">
                  Belum ada akaun? 
                  <span className="font-medium text-indigo-600 hover:text-indigo-500 ml-1 cursor-pointer">Daftar sekarang</span>
                </p>
              </div>
            </div>
          ) : (
            <div className="space-y-6">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-3">Kod Pengesahan</label>
                <div className="flex justify-between items-center">
                  {otp.map((digit, index) => (
                    <input
                      key={index}
                      ref={otpInputRefs[index]}
                      type="text"
                      value={digit}
                      onChange={(e) => handleOtpChange(index, e)}
                      onKeyDown={(e) => handleKeyDown(index, e)}
                      className="w-12 h-12 text-center text-xl font-medium border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                      maxLength={1}
                      pattern="[0-9]"
                      inputMode="numeric"
                      autoComplete="one-time-code"
                    />
                  ))}
                </div>
              </div>
              
              <div className="flex justify-between items-center">
                <button
                  type="button"
                  onClick={() => setStep(1)}
                  className="text-sm text-indigo-600 hover:text-indigo-500"
                >
                  Tukar Nombor Telefon
                </button>
                <button
                  type="button"
                  className="text-sm text-indigo-600 hover:text-indigo-500"
                >
                  Hantar Semula Kod
                </button>
              </div>
              
              <button
                type="button"
                onClick={handleVerifyOTP}
                disabled={otp.join('').length !== 6}
                className={`w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white ${
                  otp.join('').length === 6 
                    ? 'bg-indigo-600 hover:bg-indigo-700' 
                    : 'bg-indigo-300 cursor-not-allowed'
                } focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500`}
              >
                Sahkan
              </button>
            </div>
          )}
        </div>
      </div>
    );
  };
  
  // Profile component
  const ProfilePage = () => (
    <div className="p-4 space-y-6">
      <div className="flex flex-col items-center pb-6 border-b border-gray-200">
        <div className="w-24 h-24 rounded-full bg-gray-200 overflow-hidden mb-4">
          <img src={userData.profilePic} alt="Profil" className="w-full h-full object-cover" />
        </div>
        <h2 className="text-xl font-bold">{userData.name}</h2>
        <p className="text-gray-500">Affiliate Premium</p>
        
        <div className="mt-4 w-full">
          <div className="flex justify-between items-center mb-2">
            <span className="text-sm font-medium">Tahap Affiliate</span>
            <span className="text-sm">Emas (825/1000 XP)</span>
          </div>
          <div className="w-full bg-gray-200 rounded-full h-2.5">
            <div className="bg-yellow-400 h-2.5 rounded-full" style={{ width: '82.5%' }}></div>
          </div>
        </div>
      </div>
      
      <div className="space-y-4">
        <h3 className="text-lg font-medium">Maklumat Akaun</h3>
        
        <div className="space-y-3">
          <div className="flex justify-between">
            <span className="text-gray-600">E-mel</span>
            <span className="font-medium">alex.johnson@example.com</span>
          </div>
          <div className="flex justify-between">
            <span className="text-gray-600">Ahli Sejak</span>
            <span className="font-medium">15 Mac 2024</span>
          </div>
          <div className="flex justify-between">
            <span className="text-gray-600">Kaedah Pembayaran</span>
            <span className="font-medium">PayPal ····2546</span>
          </div>
          <div className="flex justify-between">
            <span className="text-gray-600">Kod Rujukan</span>
            <span className="font-medium">ALEXJ25</span>
          </div>
        </div>
      </div>
      
      <button
        onClick={() => setCurrentPage('dashboard')}
        className="mt-4 w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none"
      >
        Kembali ke Dashboard
      </button>
    </div>
  );
  
  // Dashboard component
  const DashboardPage = () => (
    <div className="p-4 space-y-6">
      <div className="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-4 text-white">
        <div className="flex justify-between items-center">
          <div>
            <p className="text-sm opacity-80">Jumlah Pendapatan</p>
            <h2 className="text-2xl font-bold">{userData.earnings}</h2>
          </div>
          <div className="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
            <TrendingUp size={24} />
          </div>
        </div>
      </div>
      
      <div className="grid grid-cols-2 gap-4">
        <div className="bg-white rounded-xl p-4 shadow-sm">
          <p className="text-sm text-gray-500">Jualan</p>
          <h3 className="text-xl font-bold">{userData.salesCount}</h3>
        </div>
        <div className="bg-white rounded-xl p-4 shadow-sm">
          <p className="text-sm text-gray-500">Klik</p>
          <h3 className="text-xl font-bold">{userData.clickCount}</h3>
        </div>
        <div className="bg-white rounded-xl p-4 shadow-sm">
          <p className="text-sm text-gray-500">Penukaran</p>
          <h3 className="text-xl font-bold">{userData.conversionRate}</h3>
        </div>
        <div className="bg-white rounded-xl p-4 shadow-sm">
          <p className="text-sm text-gray-500">Kedudukan</p>
          <h3 className="text-xl font-bold">#42</h3>
        </div>
      </div>
      
      <div className="bg-white rounded-xl p-4 shadow-sm">
        <div className="flex justify-between items-center mb-4">
          <h3 className="text-lg font-medium">Misi Aktif</h3>
          <button 
            onClick={() => setCurrentPage('missions')}
            className="text-sm text-indigo-600 flex items-center"
          >
            Lihat semua <ArrowRight size={16} className="ml-1" />
          </button>
        </div>
        
        <div className="space-y-4">
          {missionData.slice(0, 3).map(mission => (
            <div key={mission.id} className="flex items-center">
              <div className="mr-3">
                {mission.completed ? 
                  <CheckCircle className="text-green-500" size={20} /> : 
                  <div className="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                }
              </div>
              <div className="flex-1">
                <p className={`text-sm ${mission.completed ? 'text-gray-500' : 'text-gray-700'}`}>
                  {mission.title}
                </p>
                {!mission.completed && (
                  <div className="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                    <div 
                      className="bg-indigo-600 h-1.5 rounded-full" 
                      style={{ width: `${(mission.progress / mission.target) * 100}%` }}
                    ></div>
                  </div>
                )}
              </div>
              <div className="text-xs font-medium text-gray-500">
                {mission.reward}
              </div>
            </div>
          ))}
        </div>
      </div>
      
      <div className="bg-white rounded-xl p-4 shadow-sm">
        <div className="flex justify-between items-center mb-4">
          <h3 className="text-lg font-medium">Jenama Teratas</h3>
          <button 
            onClick={() => setCurrentPage('brands')}
            className="text-sm text-indigo-600 flex items-center"
          >
            Lihat semua <ArrowRight size={16} className="ml-1" />
          </button>
        </div>
        
        <div className="flex space-x-4 overflow-x-auto pb-2">
          {brandsData.map(brand => (
            <div key={brand.id} className="flex flex-col items-center min-w-[80px]">
              <div className="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                <img src={brand.logo} alt={brand.name} className="w-10 h-10 object-contain" />
              </div>
              <p className="text-xs font-medium mt-2">{brand.name}</p>
              <p className="text-xs text-gray-500">{brand.commission}</p>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
  
  // Missions component
  const MissionsPage = () => (
    <div className="p-4 space-y-6">
      <div className="flex items-center justify-between mb-4">
        <h2 className="text-xl font-bold">Misi</h2>
        <div className="text-sm font-medium text-indigo-600">
          825 XP Diperoleh
        </div>
      </div>
      
      <div className="bg-white rounded-xl p-4 shadow-sm mb-4">
        <div className="flex justify-between items-center mb-3">
          <h3 className="text-lg font-medium">Misi Harian</h3>
          <span className="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Reset dalam 8j</span>
        </div>
        
        <div className="space-y-4">
          <div className="flex items-center">
            <div className="mr-3">
              <div className="h-5 w-5 rounded-full border-2 border-gray-300"></div>
            </div>
            <div className="flex-1">
              <p className="text-sm text-gray-700">Kongsi 2 pautan affiliate hari ini</p>
              <div className="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                <div className="bg-indigo-600 h-1.5 rounded-full" style={{ width: '50%' }}></div>
              </div>
              <p className="text-xs text-gray-500 mt-1">1/2 selesai</p>
            </div>
            <div className="text-xs font-medium text-gray-500">
              25 XP
            </div>
          </div>
          
          <div className="flex items-center">
            <div className="mr-3">
              <CheckCircle className="text-green-500" size={20} />
            </div>
            <div className="flex-1">
              <p className="text-sm text-gray-500">Log masuk ke dashboard</p>
            </div>
            <div className="text-xs font-medium text-gray-500">
              10 XP
            </div>
          </div>
        </div>
      </div>
      
      <div className="bg-white rounded-xl p-4 shadow-sm">
        <h3 className="text-lg font-medium mb-4">Misi Pencapaian</h3>
        
        <div className="space-y-5">
          {missionData.map(mission => (
            <div key={mission.id} className="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
              <div className="flex items-center">
                <div className="mr-3">
                  {mission.completed ? 
                    <CheckCircle className="text-green-500" size={20} /> : 
                    <div className="h-5 w-5 rounded-full border-2 border-gray-300"></div>
                  }
                </div>
                <div className="flex-1">
                  <div className="flex justify-between">
                    <p className={`text-sm ${mission.completed ? 'text-gray-500' : 'text-gray-700'}`}>
                      {mission.title}
                    </p>
                    <div className="text-xs font-medium text-gray-500">
                      {mission.reward}
                    </div>
                  </div>
                  
                  {!mission.completed && (
                    <>
                      <div className="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                        <div 
                          className="bg-indigo-600 h-1.5 rounded-full" 
                          style={{ width: `${Math.min((mission.progress / mission.target) * 100, 100)}%` }}
                        ></div>
                      </div>
                      <p className="text-xs text-gray-500 mt-1">
                        {mission.progress}/{mission.target} selesai
                      </p>
                    </>
                  )}
                  
                  {mission.completed && (
                    <div className="mt-1 flex">
                      <CheckCircle2 size={14} className="text-green-500 mr-1" />
                      <p className="text-xs text-green-600">Selesai</p>
                    </div>
                  )}
                </div>
              </div>
              
              {mission.completed && (
                <button className="mt-2 px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg">
                  Tuntut Ganjaran
                </button>
              )}
            </div>
          ))}
        </div>
      </div>
    </div>
  );
  
  // Rewards component
  const RewardsPage = () => (
    <div className="p-4 space-y-6">
      <div className="flex items-center justify-between mb-4">
        <h2 className="text-xl font-bold">Ganjaran</h2>
        <div className="text-sm font-medium bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
          1,250 Mata
        </div>
      </div>
      
      <div className="grid grid-cols-1 gap-4">
        {rewardsData.map(reward => (
          <div key={reward.id} className="bg-white rounded-xl p-4 shadow-sm">
            <div className="flex items-center">
              <div className="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-xl mr-4">
                {reward.icon}
              </div>
              <div className="flex-1">
                <h3 className="font-medium">{reward.title}</h3>
                <p className="text-sm text-gray-500">{reward.amount}</p>
              </div>
              <button 
                className={`px-4 py-2 rounded-lg text-sm font-medium ${
                  reward.available 
                    ? 'bg-indigo-600 text-white' 
                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                }`}
                disabled={!reward.available}
              >
                {reward.available ? 'Tebus' : 'Terkunci'}
              </button>
            </div>
          </div>
        ))}
      </div>
      
      <div className="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-4 text-white">
        <div className="flex items-center">
          <div className="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
            <Gift size={24} />
          </div>
          <div>
            <h3 className="font-medium">Jemput Rakan & Dapatkan Ganjaran</h3>
            <p className="text-sm opacity-80">Dapat 500 mata setiap rujukan</p>
          </div>
        </div>
        <button className="mt-4 w-full bg-white text-indigo-600 py-2 rounded-lg font-medium text-sm">
          Dapatkan Pautan Rujukan
        </button>
      </div>
    </div>
  );
  
  // Brands component
  const BrandsPage = () => (
    <div className="p-4 space-y-6">
      <h2 className="text-xl font-bold mb-4">Jenama Rakan Kongsi</h2>
      
      <div className="grid grid-cols-1 gap-4">
        {brandsData.map(brand => (
          <div key={brand.id} className="bg-white rounded-xl p-4 shadow-sm">
            <div className="flex items-center">
              <div className="h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden mr-4">
                <img src={brand.logo} alt={brand.name} className="w-12 h-12 object-contain" />
              </div>
              <div className="flex-1">
                <h3 className="font-medium">{brand.name}</h3>
                <p className="text-sm text-gray-500">Komisen: {brand.commission}</p>
                <div className="flex items-center mt-1">
                  <div className="w-2 h-2 rounded-full bg-green-500 mr-1"></div>
                  <span className="text-xs text-green-600">Aktif</span>
                </div>
              </div>
              <button className="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-medium">
                Dapatkan Pautan
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
  
  // Navigation component
  const Navigation = () => (
    <div className="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
      <div className="flex justify-around">
        <button 
          onClick={() => setCurrentPage('dashboard')}
          className={`flex flex-col items-center p-2 ${currentPage === 'dashboard' ? 'text-indigo-600' : 'text-gray-500'}`}
        >
          <Home size={20} />
          <span className="text-xs mt-1">Utama</span>
        </button>
        <button 
          onClick={() => setCurrentPage('missions')}
          className={`flex flex-col items-center p-2 ${currentPage === 'missions' ? 'text-indigo-600' : 'text-gray-500'}`}
        >
          <Award size={20} />
          <span className="text-xs mt-1">Misi</span>
        </button>
        <button 
          onClick={() => setCurrentPage('rewards')}
          className={`flex flex-col items-center p-2 ${currentPage === 'rewards' ? 'text-indigo-600' : 'text-gray-500'}`}
        >
          <Gift size={20} />
          <span className="text-xs mt-1">Ganjaran</span>
        </button>
        <button 
          onClick={() => setCurrentPage('brands')}
          className={`flex flex-col items-center p-2 ${currentPage === 'brands' ? 'text-indigo-600' : 'text-gray-500'}`}
        >
          <ExternalLink size={20} />
          <span className="text-xs mt-1">Jenama</span>
        </button>
      </div>
    </div>
  );
  
  // Header component
  const Header = () => (
    <div className="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 px-4 py-3 flex justify-between items-center z-10">
      <h1 className="font-bold text-lg">Pusat Affiliate</h1>
      <div className="flex items-center space-x-3">
        <button className="p-2 relative">
          <Bell size={20} />
          <span className="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
        </button>
        <button 
          onClick={() => setCurrentPage('profile')}
          className="h-8 w-8 rounded-full bg-gray-200 overflow-hidden"
        >
          <img src={userData.profilePic} alt="Profile" className="w-full h-full object-cover" />
        </button>
      </div>
    </div>
  );
  
  // Main app
  if (!isLoggedIn) {
    return <LoginPage />;
  }
  
  return (
    <div className="bg-gray-50 min-h-screen">
      <Header />
      
      <div className="pt-16 pb-20">
        {currentPage === 'dashboard' && <DashboardPage />}
        {currentPage === 'profile' && <ProfilePage />}
        {currentPage === 'missions' && <MissionsPage />}
        {currentPage === 'rewards' && <RewardsPage />}
        {currentPage === 'brands' && <BrandsPage />}
      </div>
      
      <Navigation />
    </div>
  );
};

export default AffiliateDashboard;
