import { ModuleWithProviders } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LoginComponent } from './components/login/login.component'; 
import { TherapistRegisterComponent } from './components/therapist-register/therapist-register.component'; 
import { UserRegisterComponent } from './components/user-register/user-register.component'; 

const appRoutes: Routes = [
  { path: 'login', component: LoguinComponent },
  { path: 'therapist-register', component: TherapistRegisterComponent },
  { path: 'user-register', component: UserRegisterComponent },
]; 

export const appRoutingProviders: any[] = [];
export const: routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);
