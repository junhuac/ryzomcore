INCLUDE_DIRECTORIES(    ${CMAKE_CURRENT_BINARY_DIR}
                                                ${CMAKE_CURRENT_SOURCE_DIR}
                                                ${QT_INCLUDES})

INCLUDE( ${QT_USE_FILE} )

FILE(GLOB NEL_LAUNCHER_SRC *.cpp)
SET(NEL_LAUNCHER_HDR nel_launcher_dlg.h)
SET(NEL_LAUNCHER_UIS nel_launcher_dlg.ui)
SET(NEL_LAUNCHER_RCS )

SET( QT_USE_QT3SUPPORT TRUE)
SET( QT_USE_QTXML TRUE)

QT4_ADD_RESOURCES( NEL_LAUNCHER_RC_SRCS ${NEL_LAUNCHER_RCS} )
QT4_WRAP_UI( NEL_LAUNCHER_UI_HDRS ${NEL_LAUNCHER_UIS} )
QT4_WRAP_CPP( NEL_LAUNCHER_MOC_SRCS ${NEL_LAUNCHER_HDR})

ADD_EXECUTABLE(nel_launcher_qt WIN32 ${NEL_LAUNCHER_SRC} ${NEL_LAUNCHER_MOC_SRCS} ${NEL_LAUNCHER_RC_SRCS} ${NEL_LAUNCHER_UI_HDRS})

INCLUDE_DIRECTORIES(${QT_INCLUDES})

TARGET_LINK_LIBRARIES(nel_launcher_qt
						${QT_LIBRARIES}
						${QT_QTMAIN_LIBRARY}
						nelmisc
						nelnet)

NL_DEFAULT_PROPS(nel_launcher_qt "NelNS, Launcher: NeL Launcher Qt")
NL_ADD_RUNTIME_FLAGS(nel_launcher_qt)

ADD_DEFINITIONS(${QT_DEFINITIONS})

INSTALL(TARGETS nel_launcher_qt RUNTIME DESTINATION bin COMPONENT launcher)
IF(WIN32)
  INSTALL(FILES nel_launcher.cfg DESTINATION bin COMPONENT launcher)
ELSE(WIN32)
  INSTALL(FILES nel_launcher.cfg DESTINATION ${NL_ETC_PREFIX}/nelns COMPONENT launcher)
ENDIF(WIN32)
