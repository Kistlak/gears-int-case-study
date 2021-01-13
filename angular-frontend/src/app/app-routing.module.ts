import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {PublicComponent} from './public/public.component';
import {SecureComponent} from './secure/secure.component';
import {HomeComponent} from './public/home/home.component';
import {LoginComponent} from './public/login/login.component';
import {RegisterComponent} from './public/register/register.component';
import {AddBooksComponent} from './public/add-books/add-books.component';

const routes: Routes = [
    {
        path: '',
        component: PublicComponent,
        children: [
            {path: '', component: HomeComponent},
            {path: 'login', component: LoginComponent},
            {path: 'register', component: RegisterComponent},
            {path: 'add_books', component: AddBooksComponent},
        ]
    },
    {path: 'secure', component: SecureComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
