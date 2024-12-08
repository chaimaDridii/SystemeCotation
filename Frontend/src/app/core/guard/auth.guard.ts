import { Injectable } from "@angular/core";
import {
  Router,
  CanActivate,
  ActivatedRouteSnapshot,
  RouterStateSnapshot,
} from "@angular/router";

import { AuthService } from "../service/auth.service";

@Injectable({
  providedIn: "root",
})
export class AuthGuard implements CanActivate {
  constructor(private authService: AuthService, private router: Router) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    console.log(localStorage.getItem("currentUser"))
    if (localStorage.getItem("currentUser") != "" ||localStorage.getItem("currentUser") != null ) {
      
      return false;
    }
    else
    {this.router.navigate(["/authentication/signin"]);
    return false;}

    
  }
}
