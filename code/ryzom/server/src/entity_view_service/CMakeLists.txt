FILE(GLOB SRC *.cpp *.h)

#LIST(REMOVE_ITEM SRC ${CMAKE_CURRENT_SOURCE_DIR}/service.cpp ${CMAKE_CURRENT_SOURCE_DIR}/service.h)

ADD_EXECUTABLE(ryzom_entity_view_service ${SRC})

INCLUDE_DIRECTORIES(${RZ_SERVER_SRC_DIR} ${NEL_INCLUDE_DIR})

TARGET_LINK_LIBRARIES(ryzom_entity_view_service
						ryzom_adminmodules
						ryzom_gameshare
						ryzom_servershare
						ryzom_aishare
						nelmisc
						nelnet
						nelgeorges
						nelligo)

NL_DEFAULT_PROPS(ryzom_entity_view_service "Ryzom, Services: Entity View Service (EVS)")
NL_ADD_RUNTIME_FLAGS(ryzom_entity_view_service)

INSTALL(TARGETS ryzom_entity_view_service RUNTIME DESTINATION sbin COMPONENT services)

