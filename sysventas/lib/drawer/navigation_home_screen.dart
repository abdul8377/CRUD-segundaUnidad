import 'package:sysventas/theme/AppTheme.dart';
import 'package:sysventas/drawer/drawer_user_controller.dart';
import 'package:sysventas/drawer/home_drawer.dart';
import 'package:sysventas/ui/Emprendimiento/emprendimiento_main.dart';
import 'package:sysventas/ui/ZonasTuristicas/zonasTuristicas_main.dart';
import 'package:sysventas/ui/help_screen.dart';
import 'package:flutter/material.dart';
import 'package:sysventas/ui/producto/producto_main.dart';
import 'package:sysventas/ui/tipoDeNegocio/tiponegocio_main.dart';

class NavigationHomeScreen extends StatefulWidget {
  @override
  _NavigationHomeScreenState createState() => _NavigationHomeScreenState();
}

class _NavigationHomeScreenState extends State<NavigationHomeScreen> {
  Widget? screenView;
  DrawerIndex? drawerIndex;

  @override
  void initState() {
    drawerIndex = DrawerIndex.HOME;
    screenView = HelpScreen();
    super.initState();
  }


  @override
  Widget build(BuildContext context) {
    return Container(
      //color: AppTheme.themeData.primaryColor,
      child: SafeArea(
        top: false,
        bottom: false,
        child: Scaffold(
          backgroundColor: AppTheme.themeData.primaryColor,
          //appBar: CustomAppBar(accionx: accion as Function),
          body: DrawerUserController(
            screenIndex: drawerIndex!!,
            drawerWidth: MediaQuery.of(context).size.width * 0.75,
            onDrawerCall: (DrawerIndex drawerIndexdata) {
              changeIndex(drawerIndexdata);
              //callback from drawer for replace screen as user need with passing DrawerIndex(Enum index)
            },
            screenView: screenView!!,
            drawerIsOpen: (bool ) {  },
            //we replace screen view as we need on navigate starting screens like MyHomePage, HelpScreen, FeedbackScreen, etc...
          ),
        ),
      ),
    );
  }

  void changeIndex(DrawerIndex drawerIndexdata) {
    if (drawerIndex != drawerIndexdata) {
      drawerIndex = drawerIndexdata;
      if (drawerIndex == DrawerIndex.HOME) {
        setState(() {
          screenView = HelpScreen();
        });
      } else if (drawerIndex == DrawerIndex.FeedBack) {
        setState(() {
          screenView = MainProducto();
        });
      } else if (drawerIndex == DrawerIndex.TipoNegocio) {
        setState(() {
          screenView = MainTipoNegocio();
        });

      } else if (drawerIndex == DrawerIndex.Emprendimientos) {
        setState(() {
          screenView = EmprendimientoMain();
        });
      } else if (drawerIndex == DrawerIndex.ZonasTuristicas) {
        setState(() {
          screenView = ZonasTuristicasMain();
        });

      } else if (drawerIndex == DrawerIndex.Imagex) {
        setState(() {
          //screenView = MainUploadImage();
        });
      } else {
        //do in your way......
      }
    }
  }
}
